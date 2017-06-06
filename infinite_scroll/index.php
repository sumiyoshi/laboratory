<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>

無限スクロール<br/>

<div id="content">

</div>

<script>

    $(function () {

        var next_id = false;
        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();

        load_content('1');

        $(window).bind("scroll", function () {

            if ((scrollHeight - scrollPosition) / scrollHeight <= 0.05) {

                var id = next_id;
                next_id = false;

                if (id !== false) {
                    load_content(id);
                }
            }
        });

        function load_content(page) {

            $.get('/api.php', {id: page}, function (data) {

                if (data.status === false) {
                    return;
                }

                next_id = data.next_id;


                history.pushState(null, null, "/page/" + page);
                $('title').text(page);

                $('#content').append(data.content);
            });
        }

    });

</script>
</body>
</html>