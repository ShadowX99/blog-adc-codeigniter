<br>

<?php 

/**
 * Blogin Project
 *
 * Using CodeIgniter Framework supporting REST API
 *
 * @category Blog
 * @package  Blog Project
 * @author   Arefat Hyeredin
 */

/**
 * Home Page View
 *    It provides general introductory information about the project.
 */

 ?>
<h3>Welcome to Blogin </h3>

<div class="jumbotron">
  <h1 class="display-3">Hello, People.</h1>
  <p class="lead">This is a blog application developed at ADC Reasearch and Development in fulfillment of a summer internship program by Arefat Hyeredin using CodeIgniter PHP MVC Framework and concepts of REST API.</p>
  <hr>
  <p class="lead">It has posts, users, categories API with full CRUD functionality and Comments Section.
  It also has a trivia option using opentdb's API.</p>

    <a class="btn btn-primary btn-lg" href="<?php echo base_url(); ?>users/register" role="button">Try it out by Signing Up.</a>
  
</div>