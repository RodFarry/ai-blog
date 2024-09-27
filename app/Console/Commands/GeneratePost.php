<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Services\OpenAIService;
use Illuminate\Support\Str;

class GeneratePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new blog post using OpenAI ChatGPT';

    /**
     * Topics for blog posts.
     *
     * @var array
     */
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

    /**
     * Create a new command instance.
     *
     * @param OpenAIService $openAIService
     */
    public function __construct(OpenAIService $openAIService)
    {
        parent::__construct();
        $this->openAIService = $openAIService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Select a random topic
        $topic = $this->topics[array_rand($this->topics)];

        // Generate content using OpenAI
        try {
            $content = $this->openAIService->generatePostContent("Write a blog post about {$topic}");

            // Generate the post and save it to the database
            Post::create([
                'title' => Str::title($topic),
                'excerpt' => Str::limit($content, 150),
                'content' => $content,
                'category' => 'Internal Communications',
                'tags' => json_encode(['Internal Communications', 'AI Generated']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->info('New post created: ' . $topic);

            // Optional: Add a delay of 60 seconds (or more) if you're making multiple requests
            sleep(60);

        } catch (\Exception $e) {
            $this->error('Error generating post: ' . $e->getMessage());
        }
    }

}
