<h2><?= $title; ?></h2>

<?php echo validation_errors(); 

/**
 * Post Editing View- It provides a form to edit posts that have been uploaded.
 * 
 *    with fields like title, body, category, image selection with
 *    the previous content loaded.
 */

?>

<?php echo form_open('posts/update'); ?>
	<input type="hidden" name="id" value="<?php echo $post['id']; ?>">
  <div class="form-group">
    <label>Title</label>
    <input type="text" class="form-control" name="title" placeholder="Add Title" value="<?php echo $post['title']; ?>">
  </div>

  <div class="form-group">
    <label>Body</label>
    <textarea id="editor1" class="form-control" name="body" placeholder="Add Body" cols="60" rows="14"><?php echo $post['body']; ?></textarea>
  </div>

  <div class="form-group">
  <label>Category</label>
  <select name="category_id" class="form-control">
    <?php foreach($categories as $category): ?>
      <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
    <?php endforeach; ?>
  </select>
  </div>
  
  <button type="submit" class="btn btn-success">Submit</button>
</form>