<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative container mx-auto px-6 py-24">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4 leading-tight">
                    {{ $about->get('title') }}
                </h1>
                <p class="text-xl text-emerald-100 max-w-2xl mx-auto leading-relaxed">
                    کشف کنید که چه چیزی ما را متمایز می‌کند
                </p>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-white/5 rounded-full -translate-x-36 -translate-y-36"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full translate-x-48 translate-y-48"></div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-16">
        <div class="max-w-4xl mx-auto">
            <div class="space-y-8 mb-16">
                <div class="lg:col-span-5 mb-8">
                    <div class="relative group">
                        <div class="absolute inset-0 rounded-2xl opacity-25 group-hover:opacity-40 transition-opacity duration-300"></div>
                        <img
                            src="{{ $about->has('image') ? asset($about->get('image')) : 'https://placehold.co/600x400/EEE/31343C' }}"
                            alt="About Us Image"
                            class="relative w-full object-contain rounded-2xl transform group-hover:scale-[1.02] transition-transform duration-500"/>
                    </div>
                </div>

                <div class="lg:col-span-5 space-y-8">
                    <!-- Main Content -->
                    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8" id="ck-content">
                        {!! $about->get('description') !!}
                    </div>

                    <!-- Feature Cards -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">کیفیت برتر</h3>
                            <p class="text-slate-600">ما متعهد به ارائه بالاترین کیفیت در تمام خدمات خود هستیم</p>
                        </div>

                        <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl p-6 border border-teal-200">
                            <div class="w-12 h-12 bg-teal-500 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">نوآوری</h3>
                            <p class="text-slate-600">همیشه در جستجوی راه‌های جدید و بهتر برای خدمت رسانی هستیم</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <section class="text-center mt-16">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl p-12 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-bold mb-4">آماده همکاری هستید؟</h2>
                        <p class="text-xl text-emerald-100 mb-8 max-w-2xl mx-auto">
                            با ما در تماس باشید و از خدمات حرفه‌ای ما بهره‌مند شوید
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('contact.us') }}" class="bg-white text-emerald-600 px-8 py-4 rounded-xl font-bold hover:bg-emerald-50 transition-colors duration-200 shadow-lg">
                                تماس با ما
                            </a>
                        </div>
                    </div>

                    <!-- Background Decoration -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full translate-x-32 -translate-y-32"></div>
                    <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/5 rounded-full -translate-x-40 translate-y-40"></div>
                </div>
            </section>
        </div>
    </main>

    <style>
        /* Enhanced CKEditor Content Styles */
        #ck-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #334155;
        }

        /* Headings with better spacing and colors */
        #ck-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            margin-top: 2rem;
            color: #0f172a;
            background: linear-gradient(135deg, #059669, #0d9488);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        #ck-content h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            margin-top: 1.75rem;
            color: #1e293b;
            position: relative;
        }

        #ck-content h2:before {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 0;
            width: 3rem;
            height: 0.25rem;
            background: linear-gradient(90deg, #059669, #0d9488);
            border-radius: 0.125rem;
        }

        #ck-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            margin-top: 1.5rem;
            color: #334155;
        }

        #ck-content h4 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            margin-top: 1.25rem;
            color: #475569;
        }

        #ck-content h5, #ck-content h6 {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            margin-top: 1rem;
            color: #64748b;
        }

        /* Enhanced paragraphs */
        #ck-content p {
            margin-bottom: 1.5rem;
            color: #475569;
            text-align: justify;
        }

        /* Styled lists */
        #ck-content ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 1.5rem;
        }

        #ck-content ul li {
            position: relative;
            padding-left: 2rem;
            margin-bottom: 0.75rem;
            color: #475569;
        }

        #ck-content ul li:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0.75rem;
            width: 0.5rem;
            height: 0.5rem;
            background: linear-gradient(135deg, #059669, #0d9488);
            border-radius: 50%;
        }

        #ck-content ol {
            padding-left: 2rem;
            margin-bottom: 1.5rem;
        }

        #ck-content ol li {
            margin-bottom: 0.75rem;
            color: #475569;
        }

        /* Enhanced blockquotes */
        #ck-content blockquote {
            border-left: 0.25rem solid #059669;
            background: linear-gradient(90deg, #f0fdf4, #ecfdf5);
            padding: 1.5rem 2rem;
            margin: 2rem 0;
            border-radius: 0 0.75rem 0.75rem 0;
            font-style: italic;
            color: #374151;
            position: relative;
            direction: rtl;
        }

        #ck-content blockquote:before {
            content: '"';
            font-size: 4rem;
            color: #059669;
            position: absolute;
            top: -0.5rem;
            right: 1rem;
            opacity: 0.3;
        }

        /* Modern tables */
        #ck-content table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 2rem 0;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        #ck-content th {
            background: linear-gradient(135deg, #059669, #0d9488);
            color: white;
            font-weight: 600;
            padding: 1rem;
            text-align: right;
        }

        #ck-content td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            background: white;
        }

        #ck-content tr:nth-child(even) td {
            background: #f8fafc;
        }

        #ck-content tr:hover td {
            background: #f1f5f9;
        }

        /* Enhanced code blocks */
        #ck-content pre {
            background: #1e293b;
            color: #e2e8f0;
            padding: 1.5rem;
            border-radius: 0.75rem;
            overflow-x: auto;
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            font-size: 0.9rem;
            margin: 1.5rem 0;
            border: 1px solid #334155;
        }

        #ck-content code {
            background: #f1f5f9;
            color: #059669;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid #e2e8f0;
        }

        /* Enhanced text formatting */
        #ck-content strong {
            font-weight: 700;
            color: #1e293b;
        }

        #ck-content em {
            font-style: italic;
            color: #059669;
        }

        #ck-content u {
            text-decoration: underline;
            text-decoration-color: #0d9488;
            text-decoration-thickness: 0.125rem;
        }

        /* Modern links */
        #ck-content a {
            color: #059669;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: color 0.2s ease;
        }

        #ck-content a:hover {
            color: #047857;
        }

        #ck-content a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 0.125rem;
            bottom: -0.125rem;
            left: 0;
            background: linear-gradient(90deg, #059669, #0d9488);
            transition: width 0.3s ease;
        }

        #ck-content a:hover:after {
            width: 100%;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #ck-content {
                font-size: 1rem;
                line-height: 1.7;
            }

            #ck-content h1 {
                font-size: 2rem;
            }

            #ck-content h2 {
                font-size: 1.5rem;
            }

            #ck-content table {
                font-size: 0.875rem;
            }
        }
    </style>
</div>
