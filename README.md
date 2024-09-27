# AI Blog

**AI Blog** is an automated blogging platform that generates and publishes posts about internal communications using OpenAI's GPT models. The platform is built using Laravel for the backend and React for the frontend, with a focus on dynamic content generation and image creation via OpenAI.

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Environment Variables](#environment-variables)
- [Generating Posts](#generating-posts)
- [Tech Stack](#tech-stack)
- [License](#license)

## Features
- Automatically generate blog posts using OpenAI GPT models.
- Generate relevant categories, tags, and images for each post.
- Ensure uniqueness by checking for duplicate content before publishing.
- Pagination and full post views using a React frontend with React Router.
- Dockerized environment using Laravel Sail for easy setup and deployment.

## Installation

### Prerequisites
- Docker and Docker Compose installed on your machine.
- OpenAI API key (for content and image generation).

### Steps

1. **Clone the Repository**

   ```bash
   git clone https://github.com/RodFarry/ai-blog.git
   cd ai-blog
