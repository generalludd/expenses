<?php
?>
<?php echo $error;?>

<?php echo form_open_multipart('transaction/upload');?>

<input type="file" name="transactions" size="20" />

<input type="submit" value="upload" />

</form>
