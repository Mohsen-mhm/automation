<div class="w-full flex flex-col justify-center items-center pr-7">
    <main class="container mx-auto px-4 py-12">
        <section class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-semibold mb-6">{{ $about->get('title') }}</h2>
            <img
                src="{{ $about->has('image') ? asset($about->get('image')) : "https://placehold.co/600x400/EEE/31343C" }}"
                alt="About Us Image"
                class="w-1/2 h-full rounded-lg mb-6"/>
            <div class="w-full h-full" id="ck-content">
                {!! $about->get('description') !!}
            </div>
        </section>
    </main>
    <style>
        /* General styles */
        #ck-content {
            font-size: 1rem;
            line-height: 1.6;
            color: #333;
        }

        /* Headings */
        #ck-content h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        #ck-content h2 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        #ck-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 6px;
        }

        #ck-content h4 {
            font-size: 1.25rem;
            font-weight: 500;
            margin-bottom: 6px;
        }

        #ck-content h5 {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 4px;
        }

        #ck-content h6 {
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 4px;
        }

        /* Paragraphs */
        #ck-content p {
            margin-bottom: 12px;
            color: #444;
        }

        /* Lists */
        #ck-content ul {
            list-style-type: disc;
            padding-left: 20px;
            margin-bottom: 10px;
        }

        #ck-content ol {
            list-style-type: decimal;
            padding-left: 20px;
            margin-bottom: 10px;
        }

        #ck-content li {
            margin-bottom: 4px;
        }

        /* Blockquotes */
        #ck-content blockquote {
            border-left: 4px solid #ccc;
            padding-left: 16px;
            font-style: italic;
            color: #666;
            margin-bottom: 10px;
            direction: rtl;
        }

        /* Tables */
        #ck-content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        #ck-content th, #ck-content td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #ck-content th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        /* Code Blocks */
        #ck-content pre {
            background: #f5f5f5;
            padding: 12px;
            border-radius: 6px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
        }

        #ck-content code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        /* Bold, Italic, Underline */
        #ck-content strong {
            font-weight: 700;
        }

        #ck-content em {
            font-style: italic;
        }

        #ck-content u {
            text-decoration: underline;
        }

        /* Links */
        #ck-content a {
            color: #2563eb;
            text-decoration: underline;
        }

        #ck-content a:hover {
            color: #1e40af;
        }
    </style>
</div>
