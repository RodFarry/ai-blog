<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Services\OpenAIService;
use Illuminate\Support\Str;

class GeneratePost extends Command
{
    protected $signature = 'generate:post';
    protected $description = 'Generate a new blog post using OpenAI ChatGPT';
    
    protected $topics = [
        'The future of internal communications',
        'Digital internal communications',
        'Employee engagement in internal communications',
        'Data-led communications solutions',
        'Digital transformation in communications',
        'Internet solutions for internal communication',
        'Line manager communications strategies',
    ];

    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        parent::__construct();
        $this->openAIService = $openAIService;
    }

    public function handle()
    {
        // Select a random topic
        $topic = $this->topics[array_rand($this->topics)];

        // Add some prompt variations to avoid repetitive content
        $promptVariations = [
            "Write a futuristic blog post about {$topic}.",
            "Write a blog post about {$topic} from the perspective of a startup.",
            "Discuss the benefits and challenges of {$topic} in internal communications.",
            "Explain how {$topic} has evolved in the digital age.",
            "How can {$topic} improve employee engagement?"
        ];
        
        $prompt = $promptVariations[array_rand($promptVariations)];

        // Generate content in HTML format using OpenAI
        try {
            $content = $this->openAIService->generatePostContent("Write a blog post in HTML format about {$topic}. Ensure the response includes appropriate HTML tags and remove any 'title' heading from the response.");

            // Check for duplicates based on content similarity
            $existingPost = Post::where('content', 'like', '%' . Str::limit($content, 100) . '%')->first();
            if ($existingPost) {
                $this->error('Duplicate content detected. Regenerating post...');
                $this->handle();  // Retry generating a new post
                return;
            }

            // Generate category dynamically based on the content
            $category = $this->openAIService->generatePostContent("Based on the following blog content, suggest a short two-word category: {$content}");
            $category = preg_replace('/\s+/', ' ', trim($category));
            $categoryWords = explode(' ', $category);
            $category = implode(' ', array_slice($categoryWords, 0, 2)); // Limit to two words
            $category = Str::limit($category, 255);

            // Generate tags dynamically based on the content
            $tagsResponse = $this->openAIService->generatePostContent("Based on the following blog content, suggest up to 5 tags as a JSON array: {$content}");
            $tags = json_decode($tagsResponse, true);

            if (!$tags || !is_array($tags)) {
                $tags = ['Internal Communications', 'AI Generated']; // Fallback for tags
            }

            // Generate a unique image for the post
            $image = $this->openAIService->generatePostImage("Create a unique image representing {$topic} in a professional, clean, and modern style.");
            if (!$image) {
                $image = 'https://example.com/default-image.jpg';  // Fallback to default image if none generated
            }

            // Create the post and save it to the database
            Post::create([
                'title' => Str::title($topic),
                'excerpt' => Str::limit(strip_tags($content), 150), // Strip HTML tags for excerpt
                'content' => $content, // The generated content in HTML
                'category' => Str::title($category), // Dynamically generated category
                'tags' => json_encode($tags), // JSON encode tags
                'image' => $image, // Save image URL
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->info('New post created: ' . $topic);

            // Optional: Add a delay if you're making multiple requests
            sleep(60);

        } catch (\Exception $e) {
            $this->error('Error generating post: ' . $e->getMessage());
        }
    }
}
