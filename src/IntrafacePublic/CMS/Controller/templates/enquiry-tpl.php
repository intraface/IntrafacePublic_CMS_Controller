
<div id="enquiry">
<form method="POST" action="<?php e(url('.')); ?>">
    <?php if(isset($message) && $message != '') echo '<p class="message">'.$message.'</p>'; ?>
    <div id="row"><label for="name">Navn</label><input type="text" id="name" name="name" value="<?php if(isset($this->POST['name'])) e($this->POST['name']); ?>" /></div>
    <div id="row"><label for="company">Evt. firma</label><input type="text" id="company" name="company" value="<?php if(isset($this->POST['company'])) e($this->POST['company']); ?>" /></div>
    <div id="row"><label for="phone">Telefon</label><input type="text" id="phone" name="phone" value="<?php if(isset($this->POST['phone'])) e($this->POST['phone']); ?>" /></div>
    <div id="row"><label for="email">E-mail</label><input type="text" id="email" name="email" value="<?php if(isset($this->POST['email'])) e($this->POST['email']); ?>" /></div>
    <div id="row"><label for="enquiry">Forespørgsel</label><textarea id="enquiry" name="enquiry"><?php if(isset($this->POST['enquiry'])) e($this->POST['enquiry']); ?></textarea></div>
    <div id="row"><label for="send_enquiry"></label><input type="submit" name="send_enquiry" value="  Send  " /></div>
</form>
</div>