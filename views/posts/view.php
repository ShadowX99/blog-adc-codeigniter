<br>
<h2><?php echo $post['title'];

/**
 * 	Individual Posts Page- This page shows the contents of a single post with post time, body, title.
 * 
 * 		It also provides buttons for the post creator to edit and delete the post.
 * 		This would allow the post owner to update or remove his/her post.
 * 
 */


$post['created_at'] = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post['created_at'],'Africa/Addis_Ababa');
$post['created_at']=$post['created_at']->diffForHumans();

/** 
*	This creates a human readable time for the post time with past reference using Carbon vendor.
*/

?></h2>
<div class="row">
<div class="col-md-4">

	<small class="post-date">Posted <?php echo $post['created_at']; ?></small><br><br>
	<img  class="post-thumb" src="<?php echo site_url(); ?>assets/images/posts/<?php echo $post['post_image']; ?>">
</div>

<div class="col-md-8">
	<?php echo $post['body']; ?>
</div>

<div class="col-md-12">
<?php if($this->session->userdata('user_id') == $post['user_id']): ?>
	<hr>
	<a class="btn btn-info float-right " href="<?php echo base_url(); ?>posts/edit/<?php echo $post['slug']; ?>">Edit</a>
	
	<?php echo form_open('/posts/delete/'.$post['id']); ?>
	<input type="submit" value="Delete" class="btn btn-danger float-right">
	</form>
<?php endif; 

/** 
 *	This is an edit and delete option for the post creator.
 */

?>

<hr>

<!-- Comment Section -->
<h3>Comments</h3>
<?php if($comments) : ?>
	<?php foreach($comments as $comment) : ?>
		<div class="well">
			<h5><?php echo $comment['body']; ?> [by <strong><?php echo $comment['name']; ?></strong>]</h5>
		</div>
	<?php endforeach; ?>
<?php else : ?>
	<p>No Comments To Display</p>
<?php endif; ?>
<hr>
</div>

<!-- Comment Submission Form -->
<div class="col-md-8">
<h3>Add Comment</h3>
<?php echo validation_errors(); ?>
<?php echo form_open('comments/create/'.$post['id']); ?>
	<div class="form-group">
		<label>Name</label>
		<input type="text" name="name" class="form-control" required>
	</div>
	<div class="form-group">
		<label>Email</label>
		<input type="email" name="email" class="form-control" required>
	</div>
	<div class="form-group">
		<label>Body</label>
		<textarea name="body" class="form-control" required></textarea>
	</div>
	<input type="hidden" name="slug" value="<?php echo $post['slug']; ?>">
	<button class="btn btn-primary" type="submit">Submit</button>
</form>
</div>

</div>