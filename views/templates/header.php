<html>
	<head>
		<title>Blogin</title>

    <?php

    /**
     * Blogin Project Header- Using CodeIgniter Framework supporting REST API.
     *
     * @category Blog
     * @package  Blog Project
     * @author   Arefat Hyeredin
     */

    ?>

    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.css">

    <script src="http://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
		<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css"> -->
		<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css"> -->

	</head>

<div class="container">

<!-- Navigation -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo base_url(); ?>">BLOGIN</a>
  <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor03">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url(); ?>">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>posts">Blog</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>trivia">Trivia</a>
      </li>
    </ul>

    <?php

    /**
     * Display the Login and Register links if the user is not logged in.
     * Display the create post and logout option if the user is logged in.
     *
     */

    ?>

    <ul class="navbar-nav">
      <?php if(!$this->session->userdata('logged_in')) : ?>
          <li class="nav-item mr-auto"><a class="nav-link" href="<?php echo base_url(); ?>users/login">Login</a></li>
          <li class="nav-item mr-auto"><a class="nav-link" href="<?php echo base_url(); ?>users/register">Register</a></li>
      <?php endif; ?>

      <?php if($this->session->userdata('logged_in')) : ?>
            <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>posts/create">Create Post</a></li>
            <li class="nav-item"><a  class="nav-link"href="<?php echo base_url(); ?>users/logout">Logout</a></li> <script src="http://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
      <?php endif; ?>
    </ul>

    </div>
  </div>
</nav>

  <div class="container">

      <!-- Flash messages for different Notification. -->
      <?php if($this->session->flashdata('user_registered')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_registered').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('post_created')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('post_created').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('post_updated')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('post_updated').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('category_created')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('category_created').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('post_deleted')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('post_deleted').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('login_failed')): ?>
        <?php echo '<p class="alert alert-danger">'.$this->session->flashdata('login_failed').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('user_loggedin')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedin').'</p>'; ?>
      <?php endif; ?>

       <?php if($this->session->flashdata('user_loggedout')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedout').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('category_deleted')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('category_deleted').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('invalid_email')): ?>
        <?php echo '<p class="alert alert-danger">'.$this->session->flashdata('invalid_email').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('valid_email')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('valid_email').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('email_notsent')): ?>
        <?php echo '<p class="alert alert-danger">'.$this->session->flashdata('email_notsent').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('pass_change')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('pass_change').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('AccountActive')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('AccountActive').'</p>'; ?>
      <?php endif; ?>
