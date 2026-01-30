<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

final class BlogPostSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    if (BlogPost::query()->exists()) {
      return;
    }

    // Get the first user (admin) and categories
    $admin = User::first();
    $webDevCategory = Category::where('slug', 'web-development')->first();
    $designCategory = Category::where('slug', 'design')->first();
    $techCategory = Category::where('slug', 'technology')->first();

    $posts = [
      [
        'title' => 'Getting Started with Laravel 11: A Complete Guide',
        'slug' => 'getting-started-with-laravel-11-complete-guide',
        'excerpt' => 'Laravel 11 brings exciting new features and improvements. Learn how to set up your first Laravel 11 project and explore the latest enhancements.',
        'content' => $this->getLaravelGuideContent(),
        'category_id' => $webDevCategory?->id,
        'meta_title' => 'Laravel 11 Complete Guide - Getting Started Tutorial',
        'meta_description' => 'Learn Laravel 11 from scratch with our comprehensive guide. Discover new features, setup instructions, and best practices.',
        'tags' => ['laravel', 'php', 'web-development', 'tutorial', 'framework'],
        'is_published' => true,
        'is_featured' => true,
        'published_at' => Carbon::now()->subDays(2),
      ],
      [
        'title' => 'Modern CSS Grid Layout: Building Responsive Designs',
        'slug' => 'modern-css-grid-layout-responsive-designs',
        'excerpt' => 'CSS Grid has revolutionized web layout design. Discover how to create complex, responsive layouts with ease using modern CSS Grid techniques.',
        'content' => $this->getCSSGridContent(),
        'category_id' => $designCategory?->id,
        'meta_title' => 'CSS Grid Layout Tutorial - Responsive Web Design',
        'meta_description' => 'Master CSS Grid layout for responsive web design. Learn grid properties, responsive techniques, and practical examples.',
        'tags' => ['css', 'grid', 'responsive-design', 'web-design', 'frontend'],
        'is_published' => true,
        'is_featured' => true,
        'published_at' => Carbon::now()->subDays(5),
      ],
      [
        'title' => 'JavaScript ES2024 Features Every Developer Should Know',
        'slug' => 'javascript-es2024-features-developers-should-know',
        'excerpt' => 'ES2024 introduces powerful new features to JavaScript. Explore the latest additions that will enhance your development workflow.',
        'content' => $this->getJavaScriptContent(),
        'category_id' => $techCategory?->id,
        'meta_title' => 'JavaScript ES2024 New Features Guide',
        'meta_description' => 'Discover the latest JavaScript ES2024 features including new operators, array methods, and performance improvements.',
        'tags' => ['javascript', 'es2024', 'frontend', 'programming', 'web-development'],
        'is_published' => true,
        'is_featured' => true,
        'published_at' => Carbon::now()->subDays(7),
      ],
      [
        'title' => 'Building RESTful APIs with Laravel: Best Practices',
        'slug' => 'building-restful-apis-laravel-best-practices',
        'excerpt' => 'Learn how to build robust, scalable RESTful APIs using Laravel. Cover authentication, validation, error handling, and API versioning.',
        'content' => $this->getAPIContent(),
        'category_id' => $webDevCategory?->id,
        'meta_title' => 'Laravel REST API Development - Best Practices Guide',
        'meta_description' => 'Build professional Laravel REST APIs with authentication, validation, and proper error handling. Complete guide with examples.',
        'tags' => ['laravel', 'api', 'rest', 'backend', 'php', 'web-services'],
        'is_published' => true,
        'is_featured' => false,
        'published_at' => Carbon::now()->subDays(10),
      ],
      [
        'title' => 'Vue.js 3 Composition API: A Deep Dive',
        'slug' => 'vuejs-3-composition-api-deep-dive',
        'excerpt' => 'The Composition API in Vue.js 3 offers a new way to organize component logic. Learn when and how to use this powerful feature.',
        'content' => $this->getVueContent(),
        'category_id' => $techCategory?->id,
        'meta_title' => 'Vue.js 3 Composition API Tutorial and Guide',
        'meta_description' => 'Master Vue.js 3 Composition API with practical examples, best practices, and real-world use cases.',
        'tags' => ['vuejs', 'composition-api', 'frontend', 'javascript', 'spa'],
        'is_published' => true,
        'is_featured' => false,
        'published_at' => Carbon::now()->subDays(12),
      ],
      [
        'title' => 'UI/UX Design Trends for 2024',
        'slug' => 'ui-ux-design-trends-2024',
        'excerpt' => 'Explore the latest UI/UX design trends shaping digital experiences in 2024. From minimalism to AI-powered interfaces.',
        'content' => $this->getDesignTrendsContent(),
        'category_id' => $designCategory?->id,
        'meta_title' => '2024 UI/UX Design Trends - What\'s Hot This Year',
        'meta_description' => 'Discover the top UI/UX design trends for 2024 including dark mode, minimalism, micro-interactions, and AI integration.',
        'tags' => ['ui-design', 'ux-design', 'design-trends', 'user-interface', 'user-experience'],
        'is_published' => true,
        'is_featured' => false,
        'published_at' => Carbon::now()->subDays(15),
      ],
      [
        'title' => 'Docker for PHP Developers: Complete Setup Guide',
        'slug' => 'docker-php-developers-complete-setup-guide',
        'excerpt' => 'Containerize your PHP applications with Docker. Learn how to set up development environments, manage dependencies, and deploy efficiently.',
        'content' => $this->getDockerContent(),
        'category_id' => $techCategory?->id,
        'meta_title' => 'Docker for PHP Development - Complete Setup Tutorial',
        'meta_description' => 'Learn Docker for PHP development with Laravel, MySQL, and Redis. Complete guide with docker-compose examples.',
        'tags' => ['docker', 'php', 'devops', 'containerization', 'laravel', 'development'],
        'is_published' => true,
        'is_featured' => false,
        'published_at' => Carbon::now()->subDays(18),
      ],
      [
        'title' => 'The Art of Code Reviews: Improving Team Collaboration',
        'slug' => 'art-of-code-reviews-improving-team-collaboration',
        'excerpt' => 'Effective code reviews are crucial for maintaining code quality and team growth. Learn best practices for conducting meaningful reviews.',
        'content' => $this->getCodeReviewContent(),
        'category_id' => $techCategory?->id,
        'meta_title' => 'Code Review Best Practices - Team Collaboration Guide',
        'meta_description' => 'Improve your team\'s code review process with these best practices for constructive feedback and better collaboration.',
        'tags' => ['code-review', 'team-collaboration', 'software-development', 'best-practices', 'git'],
        'is_published' => true,
        'is_featured' => false,
        'published_at' => Carbon::now()->subDays(20),
      ],
    ];

    foreach ($posts as $postData) {
      BlogPost::firstOrCreate([
        'slug' => $postData['slug'],
        'category_id' => $postData['category_id'] ?? null,
        'title' => $postData['title'],
      ], [
        'slug' => $postData['slug'],
        'excerpt' => $postData['excerpt'],
        'content' => $postData['content'],
        'meta_title' => $postData['meta_title'],
        'meta_description' => $postData['meta_description'],
        'tags' => $postData['tags'],
        'is_published' => $postData['is_published'],
        'is_featured' => $postData['is_featured'],
        'published_at' => $postData['published_at'],
        'created_at' => $postData['published_at'],
        'updated_at' => $postData['published_at'],
      ]);
    }
  }

  private function getLaravelGuideContent(): string
  {
    return '<h2>Introduction to Laravel 11</h2>
        <p>Laravel 11 represents a significant milestone in the evolution of this beloved PHP framework. With its streamlined approach and powerful new features, Laravel 11 makes web development more efficient and enjoyable than ever before.</p>
        
        <h3>What\'s New in Laravel 11?</h3>
        <ul>
            <li><strong>Streamlined Application Structure:</strong> Reduced boilerplate and cleaner project structure</li>
            <li><strong>Per-second Rate Limiting:</strong> More granular control over API throttling</li>
            <li><strong>Health Routing:</strong> Built-in health check endpoints for monitoring</li>
            <li><strong>Improved Eloquent Casts:</strong> Enhanced casting capabilities for better data handling</li>
        </ul>
        
        <h3>Getting Started</h3>
        <p>To create a new Laravel 11 project, use the Laravel installer:</p>
        <pre><code>composer create-project laravel/laravel my-project</code></pre>
        
        <p>Or use the Laravel installer:</p>
        <pre><code>laravel new my-project</code></pre>
        
        <h3>Key Features to Explore</h3>
        <p>Laravel 11 introduces several exciting features that will enhance your development workflow. The streamlined application structure reduces complexity while maintaining all the power Laravel developers love.</p>
        
        <blockquote>
        <p>"Laravel 11 focuses on developer experience while maintaining the framework\'s commitment to elegant, expressive syntax."</p>
        </blockquote>
        
        <h3>Next Steps</h3>
        <p>Now that you have Laravel 11 installed, explore the documentation and start building amazing applications. The Laravel ecosystem continues to grow with tools like Livewire, Inertia.js, and Laravel Nova.</p>';
  }

  private function getCSSGridContent(): string
  {
    return '<h2>Understanding CSS Grid Layout</h2>
        <p>CSS Grid Layout is a two-dimensional layout system for the web. It lets you lay content out in rows and columns, and has many features that make building complex layouts straightforward.</p>
        
        <h3>Grid vs Flexbox</h3>
        <p>While Flexbox is great for one-dimensional layouts, CSS Grid excels at two-dimensional layouts. Use Grid when you need to control both rows and columns simultaneously.</p>
        
        <h3>Basic Grid Setup</h3>
        <pre><code>.grid-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 20px;
}</code></pre>
        
        <h3>Responsive Grid Layouts</h3>
        <p>CSS Grid makes creating responsive layouts incredibly simple with features like <code>minmax()</code> and <code>auto-fit</code>:</p>
        
        <pre><code>.responsive-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 1rem;
}</code></pre>
        
        <h3>Advanced Grid Techniques</h3>
        <ul>
            <li><strong>Grid Areas:</strong> Name your grid areas for cleaner layouts</li>
            <li><strong>Implicit Grids:</strong> Let CSS Grid handle overflow automatically</li>
            <li><strong>Subgrid:</strong> Align nested grids with parent grids</li>
        </ul>
        
        <blockquote>
        <p>"CSS Grid is not just about replacing floats and positioning - it\'s about thinking differently about layout on the web."</p>
        </blockquote>
        
        <p>Start experimenting with CSS Grid in your next project. It will change how you approach web layout design forever.</p>';
  }

  private function getJavaScriptContent(): string
  {
    return '<h2>JavaScript ES2024: The Latest Features</h2>
        <p>ES2024 continues JavaScript\'s evolution with features that improve developer productivity and code performance. Let\'s explore the most important additions.</p>
        
        <h3>Array Grouping Methods</h3>
        <p>New array methods make data manipulation more intuitive:</p>
        <pre><code>const inventory = [
  { name: "apples", category: "fruits" },
  { name: "carrots", category: "vegetables" },
  { name: "bananas", category: "fruits" }
];

const grouped = inventory.groupBy(item => item.category);
// { fruits: [...], vegetables: [...] }</code></pre>
        
        <h3>Promise.withResolvers()</h3>
        <p>A cleaner way to create promises with external resolve/reject:</p>
        <pre><code>const { promise, resolve, reject } = Promise.withResolvers();

// Use resolve/reject from outside the promise constructor
setTimeout(() => resolve("Done!"), 1000);</code></pre>
        
        <h3>ArrayBuffer Improvements</h3>
        <p>Enhanced ArrayBuffer methods for better binary data handling:</p>
        <pre><code>const buffer1 = new ArrayBuffer(8);
const buffer2 = new ArrayBuffer(8);

// Check if buffers have the same content
const areEqual = buffer1.equals(buffer2);</code></pre>
        
        <h3>Temporal API (Proposal)</h3>
        <p>While still in proposal stage, the Temporal API promises to revolutionize date/time handling in JavaScript:</p>
        <pre><code>// Better date handling coming soon
const now = Temporal.Now.plainDateTimeISO();
const future = now.add({ days: 7, hours: 3 });</code></pre>
        
        <blockquote>
        <p>"Each new JavaScript version brings us closer to a more expressive and powerful language while maintaining backward compatibility."</p>
        </blockquote>
        
        <p>Stay updated with JavaScript\'s evolution and start experimenting with these features in your projects today!</p>';
  }

  private function getAPIContent(): string
  {
    return '<h2>Building Professional RESTful APIs with Laravel</h2>
        <p>RESTful APIs are the backbone of modern web applications. Laravel provides excellent tools for building robust, scalable APIs that follow best practices.</p>
        
        <h3>API Routes and Structure</h3>
        <p>Start by organizing your API routes properly:</p>
        <pre><code>// routes/api.php
Route::apiResource("posts", PostController::class);
Route::prefix("v1")->group(function () {
    Route::apiResource("users", UserController::class);
});</code></pre>
        
        <h3>API Resources</h3>
        <p>Use Laravel\'s API resources to transform your data:</p>
        <pre><code>class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "excerpt" => $this->excerpt,
            "published_at" => $this->published_at->toDateString(),
            "author" => new UserResource($this->author),
        ];
    }
}</code></pre>
        
        <h3>Authentication and Authorization</h3>
        <p>Implement secure authentication using Laravel Sanctum:</p>
        <pre><code>// API Authentication
Route::post("/login", [AuthController::class, "login"]);
Route::middleware("auth:sanctum")->group(function () {
    Route::get("/user", [UserController::class, "profile"]);
});</code></pre>
        
        <h3>Error Handling</h3>
        <p>Consistent error responses are crucial for API consumers:</p>
        <pre><code>public function render($request, Throwable $exception)
{
    if ($request->is("api/*")) {
        return response()->json([
            "error" => "Something went wrong",
            "message" => $exception->getMessage()
        ], 500);
    }
}</code></pre>
        
        <h3>Best Practices</h3>
        <ul>
            <li><strong>Version your APIs:</strong> Use URL versioning or header versioning</li>
            <li><strong>Validate input:</strong> Use Form Requests for comprehensive validation</li>
            <li><strong>Rate limiting:</strong> Protect your API from abuse</li>
            <li><strong>Documentation:</strong> Use tools like Laravel API Documentation Generator</li>
        </ul>
        
        <blockquote>
        <p>"A well-designed API is intuitive, consistent, and makes developers happy to work with it."</p>
        </blockquote>';
  }

  private function getVueContent(): string
  {
    return '<h2>Mastering Vue.js 3 Composition API</h2>
        <p>The Composition API is Vue 3\'s answer to complex component logic organization. It provides a more flexible and powerful way to build components.</p>
        
        <h3>Why Composition API?</h3>
        <p>The Composition API solves several limitations of the Options API:</p>
        <ul>
            <li>Better logic reuse between components</li>
            <li>More flexible code organization</li>
            <li>Better TypeScript integration</li>
            <li>Improved tree-shaking capabilities</li>
        </ul>
        
        <h3>Basic Setup Function</h3>
        <pre><code>import { ref, computed, onMounted } from "vue";

export default {
  setup() {
    const count = ref(0);
    const doubleCount = computed(() => count.value * 2);
    
    const increment = () => {
      count.value++;
    };
    
    onMounted(() => {
      console.log("Component mounted!");
    });
    
    return {
      count,
      doubleCount,
      increment
    };
  }
};</code></pre>
        
        <h3>Composables for Logic Reuse</h3>
        <p>Create reusable logic with composables:</p>
        <pre><code>// useCounter.js
import { ref } from "vue";

export function useCounter(initialValue = 0) {
  const count = ref(initialValue);
  
  const increment = () => count.value++;
  const decrement = () => count.value--;
  const reset = () => count.value = initialValue;
  
  return {
    count,
    increment,
    decrement,
    reset
  };
}</code></pre>
        
        <h3>Advanced Patterns</h3>
        <p>Combine multiple composables for complex functionality:</p>
        <pre><code>export default {
  setup() {
    const { count, increment } = useCounter();
    const { isLoading, error, fetchData } = useApi();
    const { user, login, logout } = useAuth();
    
    return {
      count,
      increment,
      isLoading,
      error,
      fetchData,
      user,
      login,
      logout
    };
  }
};</code></pre>
        
        <blockquote>
        <p>"The Composition API doesn\'t replace the Options API - it\'s an additional way to compose component logic."</p>
        </blockquote>
        
        <p>Start incorporating the Composition API into your Vue.js projects for better code organization and reusability.</p>';
  }

  private function getDesignTrendsContent(): string
  {
    return '<h2>UI/UX Design Trends Shaping 2024</h2>
        <p>As we navigate through 2024, design trends continue to evolve, influenced by technology advances, user behavior changes, and cultural shifts. Here are the key trends defining this year.</p>
        
        <h3>1. AI-Powered Personalization</h3>
        <p>Artificial intelligence is revolutionizing how we create personalized user experiences. From dynamic content adaptation to predictive interface elements, AI is making interfaces smarter and more responsive to user needs.</p>
        
        <h3>2. Sustainable Design Practices</h3>
        <p>Environmental consciousness extends to digital design. Key principles include:</p>
        <ul>
            <li>Optimized images and assets for faster loading</li>
            <li>Dark mode implementations to reduce energy consumption</li>
            <li>Minimalist designs that require less processing power</li>
            <li>Efficient code that reduces server load</li>
        </ul>
        
        <h3>3. Advanced Micro-Interactions</h3>
        <p>Micro-interactions are becoming more sophisticated, providing delightful feedback that enhances user engagement:</p>
        <pre><code>/* CSS for smooth micro-interactions */
.button {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  transform-origin: center;
}

.button:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}</code></pre>
        
        <h3>4. Immersive 3D Elements</h3>
        <p>WebGL and CSS 3D transforms are making three-dimensional elements more accessible in web design, creating depth and visual interest without compromising performance.</p>
        
        <h3>5. Inclusive Design Evolution</h3>
        <p>Accessibility is no longer an afterthought but a fundamental design principle:</p>
        <ul>
            <li>High contrast modes for better visibility</li>
            <li>Voice interface integration</li>
            <li>Gesture-based navigation options</li>
            <li>Cognitive load reduction strategies</li>
        </ul>
        
        <h3>6. Data Visualization Renaissance</h3>
        <p>With the explosion of data, designers are creating more intuitive ways to present complex information through interactive charts, animated graphs, and storytelling through data.</p>
        
        <blockquote>
        <p>"Great design in 2024 is not just about how it looks, but how it adapts, learns, and respects both users and the environment."</p>
        </blockquote>
        
        <h3>Implementation Tips</h3>
        <p>When incorporating these trends:</p>
        <ul>
            <li>Start small with one or two trends that align with your brand</li>
            <li>Always test with real users before full implementation</li>
            <li>Consider performance implications of visual enhancements</li>
            <li>Maintain consistency with your existing design system</li>
        </ul>
        
        <p>Remember, trends should enhance user experience, not overshadow functionality. The best designs seamlessly blend innovation with usability.</p>';
  }

  private function getDockerContent(): string
  {
    return '<h2>Docker for PHP Development: Complete Setup</h2>
        <p>Docker has revolutionized how we develop and deploy applications. For PHP developers, Docker offers consistent environments, easy dependency management, and simplified deployments.</p>
        
        <h3>Why Docker for PHP?</h3>
        <ul>
            <li><strong>Environment Consistency:</strong> Same environment across development, staging, and production</li>
            <li><strong>Easy Setup:</strong> New team members can get started in minutes</li>
            <li><strong>Isolation:</strong> Each project has its own environment</li>
            <li><strong>Version Management:</strong> Test different PHP versions easily</li>
        </ul>
        
        <h3>Basic Dockerfile for PHP</h3>
        <pre><code>FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application code
COPY . /var/www

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

EXPOSE 9000
CMD ["php-fpm"]</code></pre>
        
        <h3>Docker Compose for Laravel</h3>
        <p>Use Docker Compose to orchestrate multiple services:</p>
        <pre><code>version: "3.8"

services:
  app:
    build: .
    volumes:
      - ./:/var/www
    depends_on:
      - database
      - redis

  webserver:
    image: nginx:alpine
    ports:
      - "80:80"
    volumes:
      - ./:/var/www
      - ./docker/nginx:/etc/nginx/conf.d
    depends_on:
      - app

  database:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: laravel
      MYSQL_ROOT_PASSWORD: secret
    volumes:
      - dbdata:/var/lib/mysql
    ports:
      - "3306:3306"

  redis:
    image: redis:alpine
    ports:
      - "6379:6379"

volumes:
  dbdata:</code></pre>
        
        <h3>Development Workflow</h3>
        <p>Optimize your Docker workflow for development:</p>
        <pre><code># Start development environment
docker-compose up -d

# Run Laravel commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan queue:work

# Install new dependencies
docker-compose exec app composer require package-name

# Run tests
docker-compose exec app php artisan test</code></pre>
        
        <h3>Production Considerations</h3>
        <ul>
            <li><strong>Multi-stage builds:</strong> Reduce image size for production</li>
            <li><strong>Security:</strong> Use non-root users and minimal base images</li>
            <li><strong>Health checks:</strong> Implement container health monitoring</li>
            <li><strong>Secrets management:</strong> Use Docker secrets for sensitive data</li>
        </ul>
        
        <blockquote>
        <p>"Docker doesn\'t just solve the \'it works on my machine\' problem - it transforms how we think about application deployment and scaling."</p>
        </blockquote>
        
        <p>Start small with Docker in development, then gradually move to containerized production deployments as you become more comfortable with the technology.</p>';
  }

  private function getCodeReviewContent(): string
  {
    return '<h2>The Art of Effective Code Reviews</h2>
        <p>Code reviews are one of the most valuable practices in software development. They improve code quality, share knowledge, and strengthen team collaboration when done effectively.</p>
        
        <h3>Benefits of Code Reviews</h3>
        <ul>
            <li><strong>Bug Detection:</strong> Catch issues before they reach production</li>
            <li><strong>Knowledge Sharing:</strong> Learn from teammates and share expertise</li>
            <li><strong>Code Quality:</strong> Maintain consistent standards across the codebase</li>
            <li><strong>Mentorship:</strong> Guide junior developers and learn from seniors</li>
        </ul>
        
        <h3>Best Practices for Reviewers</h3>
        <p>When reviewing code, focus on these key areas:</p>
        
        <h4>1. Be Constructive, Not Critical</h4>
        <pre><code>// Instead of: "This is wrong"
// Say: "Consider using array_map() here for better readability"

// Bad comment
"This function is terrible"

// Good comment
"This function could be simplified by extracting the validation logic into a separate method"</code></pre>
        
        <h4>2. Focus on the Important Things</h4>
        <ul>
            <li>Logic errors and potential bugs</li>
            <li>Security vulnerabilities</li>
            <li>Performance implications</li>
            <li>Code maintainability and readability</li>
        </ul>
        
        <h3>Best Practices for Authors</h3>
        <p>As the author of a pull request:</p>
        
        <h4>1. Keep PRs Small and Focused</h4>
        <pre><code>// Good PR - focused on one feature
- Add user authentication endpoint
- Implement JWT token validation
- Add authentication tests

// Bad PR - too many changes
- Add user auth + fix database migrations + update README + refactor models</code></pre>
        
        <h4>2. Write Clear Descriptions</h4>
        <p>Include context, testing instructions, and any relevant information:</p>
        <pre><code>## What this PR does
Implements user authentication using JWT tokens

## How to test
1. POST to /api/login with valid credentials
2. Use returned token in Authorization header
3. Access protected routes

## Notes
- Tokens expire after 24 hours
- Refresh token endpoint coming in next PR</code></pre>
        
        <h3>Code Review Checklist</h3>
        <p>Use this checklist for consistent reviews:</p>
        <ul>
            <li>✅ Does the code solve the stated problem?</li>
            <li>✅ Are there any obvious bugs or edge cases?</li>
            <li>✅ Is the code readable and well-documented?</li>
            <li>✅ Are tests included and comprehensive?</li>
            <li>✅ Does it follow team coding standards?</li>
            <li>✅ Are there any security concerns?</li>
            <li>✅ Could performance be improved?</li>
        </ul>
        
        <h3>Handling Feedback</h3>
        <p>Both reviewers and authors should remember:</p>
        <blockquote>
        <p>"Code reviews are about the code, not the person. Approach them with curiosity and a growth mindset."</p>
        </blockquote>
        
        <h3>Tools and Automation</h3>
        <p>Leverage tools to make reviews more effective:</p>
        <ul>
            <li><strong>Linters:</strong> Catch style issues automatically</li>
            <li><strong>CI/CD:</strong> Run tests before human review</li>
            <li><strong>Code Coverage:</strong> Ensure adequate test coverage</li>
            <li><strong>Security Scanners:</strong> Identify potential vulnerabilities</li>
        </ul>
        
        <p>Remember, the goal is to ship better code while helping each other grow as developers. Great code reviews create a positive, learning-focused culture that benefits everyone.</p>';
  }
}
