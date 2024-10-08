<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Topic; // Import the Topic model
use App\Services\OpenAIService;
use Illuminate\Support\Str;

class GeneratePost extends Command
{
    protected $signature = 'generate:post';
    protected $description = 'Generate a new blog post using OpenAI ChatGPT';

    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        parent::__construct();
        $this->openAIService = $openAIService;
    }

    public function handle()
    {
        // Fetch all topics from the database
        $topics = Topic::all();

        // If no topics are available, exit with an error message
        if ($topics->isEmpty()) {
            $this->error('No topics available in the database. Please add some topics first.');
            return;
        }

        // Select a random topic from the database
        $topic = $topics->random()->title;

        // Add some dynamic prompt variations to avoid repetitive content
        $promptVariations = [
            "Write a comprehensive blog post about {$topic}.",
            "Discuss the major trends and future developments related to {$topic}.",
            "What are the key benefits and challenges of {$topic}?",
            "How does {$topic} impact the industry it relates to?",
            "Explain how {$topic} has changed or evolved over time.",
            "What are the best strategies for implementing {$topic}?",
            "Write a blog post exploring the relationship between {$topic} and technology.",
            "What are the ethical considerations around {$topic}?",
            "Discuss the historical context and future possibilities for {$topic}.",
            "How can {$topic} improve the overall performance in any organization?"
        ];
        
        // Select a random prompt variation
        $prompt = $promptVariations[array_rand($promptVariations)];

        // Generate content in HTML format using OpenAI
        try {
            $content = $this->openAIService->generatePostContent("Write a blog post in HTML format about {$topic}. Ensure the response is in British English, includes appropriate HTML tags, and remove any 'title' heading from the response.");

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
