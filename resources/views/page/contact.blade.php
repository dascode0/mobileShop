@extends('layout.user')
@section('title','Contact Us')
@section('styles')
<style>
    .icon {
      font-size: 1.5rem;
      color: #0d6efd;
      margin-right: 10px;
    }
    .form-control, .form-select {
      border-radius: 0.5rem;
    }
</style>
@endsection
@section('content')
<div class="container-fluid bg-light">
    <div class="py-2 d-flex ms-5">
        <a href="{{route('home')}}" class="text-decoration-none text-dark">Home</a>
        <span class="text-muted mx-2"> &gt; </span>
        <span class="text-secondary">Contact Us</span>
    </div>
</div>
<div class="container-fluid py-5 px-3">
    <div class="row g-4 align-items-start">
      <!-- Map -->
      <div class="col-lg-6">
        <iframe 
          src="https://maps.google.com/maps?q=121%20King%20St,%20Melbourne,%20VIC%203000&t=&z=13&ie=UTF8&iwloc=&output=embed" 
          width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
      </div>

      <!-- Contact Info and Form -->
      <div class="col-lg-6">
        <div class="mb-4">
          <h4><i class="icon bi bi-geo-alt-fill"></i> Our Office</h4>
          <p class="mb-1">AviGadgetBox, 7th Floor, Devika Tower,<br> Nehru Place, New Delhi 110019</p>
          <p class="mb-3">📞 +91 1206593444</p>
        </div>

        <div class="mb-4">
          <h4><i class="icon bi bi-telephone-fill"></i> Quick Help</h4>
          <p class="mb-1">You can ask anything you want to know about our products</p>
          <p class="mb-0">✉️ support@avigadgetbox.com</p>
          <p class="mb-3">✉️ info@avigadgetbox.com</p>
        </div>

        <div>
          <h4>Send a Message</h4>
          <form>
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Your name" required>
            </div>
            <div class="mb-3">
              <input type="email" class="form-control" placeholder="Your E-mail" required>
            </div>
            <div class="mb-3">
              <select class="form-select">
                <option selected disabled>Choose help type</option>
                <option value="1">Technical Help</option>
                <option value="2">Order Support</option>
                <option value="3">General Inquiry</option>
              </select>
            </div>
            <div class="mb-3">
              <textarea class="form-control" rows="5" placeholder="Message"></textarea>
            </div>
            <button type="submit" class="btn btn-primary px-4">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection