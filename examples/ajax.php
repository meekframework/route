<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Test Routing</title>
    </head>
    <body>
        <nav>
            <ul id="nav">
                <li><a href="/">home</a></li>
                <li><a href="/posts">view all posts</a></li>
                <li><a href="/posts/465">Post 465</a></li>
            </ul>
        </nav>
        <div id="content"></div>
        <script type="text/javascript">
            document.getElementById('nav').addEventListener('click', function (e) {
                e.preventDefault();

                if (e.target.getAttribute('href')) {
                    fetch(e.target.href)
                        .then(function (response) {
                            return response.text();
                        })
                        .then(function (content) {
                            document.getElementById('content').innerText = content;
                        });
                }

                return false;
            });
        </script>
    </body>
</html>
