<h2><?= $title ?></h2>

<?php

/**
 * Blogin Project
 *
 * Using CodeIgniter Framework supporting REST API
 *
 * @category Blog Posts
 * @package  Blog Project
 * @author   Arefat Hyeredin
 */


/**
 * Posts View- It provides a basic layout of posts to be viewed in a limited manner.
 * 
 * 	  with pagination,and categories sidebar, and a human readable post time indicator.
 * 	  The read more button would redirect to the specific post with full content.
 * 
 * @category Blog Posts
 * @package  Blog Project
 * @author   Arefat Hyeredin
 */
?>
<div class="row">

<div class="col-md-8">


<?php foreach($posts as $post) : ?>
	<h3><?php echo $post['title']; ?></h3>



	<h6 class="post-date">Posted <?php 
	
	$post['created_at'] = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post['created_at'],'Africa/Addis_Ababa');
	$post['created_at']=$post['created_at']->diffForHumans();

/** 
*	This creates a human readable time for the post time with past reference using Carbon vendor.
*/
	
	echo    $post['created_at']; ?> in <strong><?php echo $post['name']; ?></strong></h6>
	<div class="row">
		<div class="col-md-3">
			<img class="post-thumb" src="<?php echo site_url(); ?>assets/images/posts/<?php echo $post['post_image']; ?>">
		</div>
		<div class="col-md-9">
			
		<?php echo word_limiter($post['body'], 60); 
/** 
*	This limits the words to 60 in the main blog list page.The rest of the content is loaded in the individual
*	section with the read more.	
*/

		?>
		<br><br>
		<p><a class="btn btn-secondary" href="<?php echo site_url('/posts/'.$post['slug']); ?>">Read More</a></p>
		</div>
	</div>
<?php endforeach; ?>
</div>

<!-- Add New Categry sidebar -->

<div class="col-md-4">
	<?php if($this->session->userdata('logged_in')) : ?>
	<?php echo validation_errors(); ?>
	<?php echo form_open('categories/create'); ?>
		<div class="form-group">
			<input type="text" class="form-control" name="name" placeholder="New Category..." required>
			<button type="submit" class="btn btn-primary btn-block">Add New Category</button>
		</div>
	</form>
	<?php endif; ?>

<br>

<!-- Categories List -->


<div class="list-group">
  <li class="list-group-item list-group-item-action active">Categories</li>
  <?php foreach($categories as $category) : ?>
  <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
  <a href="<?php echo site_url('/categories/posts/'.$category['id']); ?>">
  <?php echo $category['name']; ?></a>
  <?php if($this->session->userdata('user_id') == $category['user_id']): ?>
		<form class="cat-delete" action="categories/delete/<?php echo $category['id']; ?>" method="POST">
			<span class="badge badge-primary badge-pill"> <input type="submit"  value="X"> </span>
		</form>
	<?php endif; 

/** 
*		This allows a category to be deleted by only the person who created it.
*/

	?>	
  <?php endforeach; ?>

	</div>	
</div>


<br><br><br>

<!-- Pagination with 3 Posts per page. -->
<div>
	<ul class="pagination pagnation-lg">
		<li class="page-item active">
			<?php echo $this->pagination->create_links(); ?>
		</li>
	</ul>
</div>
</li>
</div>

