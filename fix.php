<?php
$files1 = ['app/Models/Profile.php', 'app/Http/Controllers/ProfileController.php', 'app/Http/Controllers/AlumniController.php', 'database/factories/ProfileFactory.php'];
foreach($files1 as $file) {
    if(file_exists($file)) {
        file_put_contents($file, str_replace('graduation_year', 'batch_year', file_get_contents($file)));
    }
}

$files2 = ['app/Models/Post.php', 'app/Models/Comment.php', 'app/Http/Controllers/PostController.php', 'database/factories/PostFactory.php', 'resources/views/posts/index.blade.php'];
foreach($files2 as $file) {
    if(file_exists($file)) {
        $content = file_get_contents($file);
        $content = str_replace("\$request->content", "\$request->body", $content);
        $content = str_replace("'content'", "'body'", $content);
        $content = str_replace("\$post->content", "\$post->body", $content);
        $content = str_replace('name="content"', 'name="body"', $content);
        file_put_contents($file, $content);
    }
}
echo 'Replaced successfully!';
