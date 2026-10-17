<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href="/template/css/contact.css">
</head>

<body>
    @include('header')
    <div class="container" style="padding-top: 125px;">
        <div class="single_wrap_main row">
            <!-- Main blog post -->
            <div class="col-md-8 main-post">
                <h1>{{ $dichvu->name }}</h1> <!-- Blog post title -->
                <section>
                    <div class="post-image">
                        <img src="{{ asset($dichvu->image) }}" alt="{{ $dichvu->name }}">
                    </div>
                    <div class="post-content">
                        <p><em>Đăng lúc: {{ $dichvu->created_at->format('M d, Y') }}</em></p>
                        <!-- Post date -->
                        <p>{!! $dichvu->detail_descriptions !!}</p>
                        <!-- Full post description -->
                    </div>
                </section>
            </div>

            <!-- Related blog posts -->
            <div class="col-md-4 related-posts">
                <h2>Bài viết liên quan</h2>
                <ul>
                    @foreach ($dvposts as $post)
                    <li>
                        <a href="{{ url('dichvu-detail/' . $post->slug) }}" class="d-flex">
                            <img src="{{ asset($post->image) }}" alt="{{ $post->name }}" class="related-thumbnail">
                            <h3>{{ $post->name }}</h3>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @include('footer')
</body>


<style>
    /* Main container for blog post and related posts */
    .single_wrap_main {
        display: flex;
        gap: 20px;
        /* Space between columns */
    }

    /* Styling for the main blog post */
    .main-post {
        flex: 2;
        /* Takes more space */
    }

    .main-post .post-image img {
        width: 30%;
        height: auto;
        border-radius: 8px;
        /* Rounded corners */
    }

    .main-post .post-content {
        margin-top: 20px;
    }

    .main-post .post-content p {
        font-size: 16px;
        line-height: 1.6;
    }

    /* Styling for related blog posts */
    .related-posts {
        flex: 1;
        /* Takes less space */
    }

    .related-posts h2 {
        margin-bottom: 20px;
    }

    .related-posts ul {
        list-style-type: none;
        padding: 0;
    }

    .related-posts li {
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        /* Border between items */
        padding-bottom: 10px;
    }

    .related-posts a {
        text-decoration: none;
        color: #333;
        display: block;
        transition: color 0.3s;
    }

    .related-posts a:hover {
        color: #007bff;
        /* Color on hover */
    }

    .related-thumbnail {
        width: 40%;
        height: auto;
        border-radius: 8px;
    }

    .related-posts h3 {
        font-size: 18px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .single_wrap_main {
            flex-direction: column;
            /* Stack columns on small screens */
        }

        .main-post,
        .related-posts {
            flex: 1;
            /* Equal width on small screens */
        }
    }

    @media (max-width: 480px) {
        .related-thumbnail {
            width: 15%;
            height: auto;
            border-radius: 8px
        }
    }
</style>

</html>