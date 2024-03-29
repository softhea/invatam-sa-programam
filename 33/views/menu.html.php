<?php

use Core\Auth;
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-bottom-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Invatam Sa Programam</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?=HOME_URL?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="users">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="messages">Messages</a>
        </li>
      </ul>
      <span class="navbar-text">
	    <span>Salut, <?=Auth::user()->username?>!</span> 	
  	    <a href="logout" class="btn btn-secondary">Logout</a>
      </span>
    </div>
  </div>
</nav>