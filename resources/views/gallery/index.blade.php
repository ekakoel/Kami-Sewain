@extends('layouts.master')

@section('title', 'Product')

@section('main')
<main class="flex-shrink-0">
    <header class="header-container">
        <div class="header-caption">
            <div class="header-title">{{ $page_properties ? $page_properties->slider_title : "Gallery"; }}</div>
            <p>{{ $page_properties ? $page_properties->slider_caption : "Wedding Equipment and Facilities"; }}</p>
        </div>
    </header>
    <section class="py-5">
        <div class="container">
            @foreach ($categories as $category)
                @if (count($category->galleries) > 0)
                    <div class="section-title">
                        {{ $category->name }}
                    </div>
                    <div class="gallery m-b-35">
                        @foreach ($category->galleries as $index => $gallery)
                            <div id="categoryGallery-{{ $index }}" class="gallery-item fade-in" data-gallery-id="{{ $index }}">
                                <img src="{{ asset('images/galleries/'.$gallery->image) }}" alt="{{ $gallery->alt }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
        <!-- Modal Layar Penuh -->
        <div class="card-modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="galleryModalLabel">Galery</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="" class="img-fluid" style="max-height: 80vh;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Skrip untuk menangani modal dan memuat gambar -->
        <script>
            window.addEventListener('load', function() {
                const galleryItems = document.querySelectorAll('.gallery-item');
                const modalElement = document.getElementById('galleryModal');
                const modalImage = document.getElementById('modalImage');
                const modal = new bootstrap.Modal(modalElement); // Inisialisasi modal

                galleryItems.forEach((item, index) => {
                    setTimeout(() => item.classList.add('loaded'), index * 300); // Efek fade-in

                    // Tambahkan event click untuk modal
                    item.addEventListener('click', function() {
                        const imageSrc = this.querySelector('img').src;  // Ambil src dari gambar thumbnail
                        modalImage.src = imageSrc; // Set src untuk gambar modal
                        modal.show();  // Tampilkan modal
                    });
                });

                // Event listener untuk tombol tutup
                const buttonClose = document.querySelector('.btn-close');
                buttonClose.addEventListener('click', function() {
                    modal.hide();  // Menyembunyikan modal menggunakan Bootstrap
                });
            });
        </script>
        
    </section>
</main>
@endsection

{{-- @extends('layouts.master')

@section('title', 'Product')

@section('main')
    <main class="flex-shrink-0">
        <header class="header-container">
            <div class="header-caption">
                <div class="header-title">{{ $page_properties ? $page_properties->slider_title : "Gallery"; }}</div>
                <p>{{ $page_properties ? $page_properties->slider_caption : "Wedding Equipment and Facilities"; }}</p>
            </div>
        </header>
        <section class="py-5">
            <div class="container">
                @foreach ($categories as $category)
                    @if (count($category->galleries) > 0)
                        <div class="section-title">
                            {{ $category->name }}
                        </div>
                        <div class="gallery m-b-35">
                            @foreach ($category->galleries as $index => $gallery)
                                <div id="categoryGalery-{{ $index }}" class="gallery-item fade-in" data-gallery-id="{{ $index }}">
                                    <img src="{{ asset('images/galleries/'.$gallery->image) }}" alt="{{ $gallery->alt }}">
                                </div>
                                <!-- Modal Layar Penuh -->
                                <div class="card-modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
                                    <div class="card-modal-dialog modal-lg">
                                        <div class="card-modal-body">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="galleryModalLabel">Gallery</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="card-modal-body text-center">
                                                <img id="modalImage" src="" alt="" class="img-fluid" style="max-height: 80vh;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Skrip untuk menangani modal dan memuat gambar -->
            <script>
                window.addEventListener('load', function() {
                    const galleryItems = document.querySelectorAll('.gallery-item');
                    // Get the <span> element that closes the modal
                    var buttonClose = document.getElementsByClassName("btn-close")[0];
                    galleryItems.forEach((item, index) => {
                        setTimeout(() => item.classList.add('loaded'), index * 100); // Efek fade-in
                        // Tambahkan event click untuk modal
                        item.addEventListener('click', function() {
                            const imageSrc = this.querySelector('img').src;  // Ambil src dari gambar thumbnail
                            document.getElementById('modalImage').src = imageSrc; // Set src untuk gambar modal
                            
                            const modal = new bootstrap.Modal(document.getElementById('galleryModal'));
                            modal.show();  // Tampilkan modal
                        });
                        buttonClose.onclick = function() { 
                            modal.hide();
                            }
                    });
                });
            </script>
        </section>
    </main>
@endsection --}}
