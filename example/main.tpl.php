<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
    <title><?php e($this->document->title); ?></title>    
    <meta name="Keywords" content="<?php e($this->document->keywords); ?>" />
    <meta name="Description" content="<?php e($this->document->description); ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php e($this->document->encoding); ?>" />
    <link href="<?php e(url('/css/screen.css')); ?>" rel="stylesheet" media="screen, projection" type="text/css" />
    <link href="<?php e(url('/css/enquiry.css')); ?>" rel="stylesheet" media="screen, projection" type="text/css" />
    <style type="text/css">
        <?php echo $this->document->style; ?>
    </style>
</HEAD>
<BODY>
<div id="container">
    <div id="menu"><?php echo $this->document->navigation['html']; ?></div>
    <div class="content"><?php echo $content; ?></div>
</div>
</BODY>
</HTML>