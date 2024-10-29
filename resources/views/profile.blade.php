@extends('layouts.master')

@section('title', 'Profil')

@section('main')

    <div class="container p-t-18">
        <div class="row">
            <div class="col-12 col-md-4 m-b-18">
                <div class="card-box">
                    <div class="profile-img m-b-8">
                        @if ($user->profile_img)
                            <img src="{{ asset('images/profile/' . $user->profile_img) }}"
                                alt="Profile Image {{ $user->email }}">
                        @else
                            <img src="{{ asset('images/profile/default-profile-img.jpg') }}"
                                alt="Profile Image {{ $user->email }}">
                        @endif
                    </div>
                    <div class="detail-profile">
                        <div class="profile-title">
                            {{ $user->name }}
                        </div>
                        <div class="profile-text">
                            <span>{{ $user->email }}</span><br>
                            <span>{{ $user->phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 m-b-18">
                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card-box m-b-18">
                    <div class="card-box-header d-flex justify-content-between flex-column flex-xl-row">
                        <div class="card-box-title">Profile Details</div>
                        <span class="{{ $user->status == "Active"?"status-active":"status-blocked"; }}">{{ $user->status == "Pending"?"Unverified":$user->status; }}</span>
                    </div>
                  <div class="card-box-body">
                    <p><strong>Name</strong><br> 
                      {{ $user->name }}
                    </p>
                    
                    <p><strong>Email:</strong><br>
                      {{ $user->email }}
                    </p>
                    <p><strong>Telephone:</strong><br>
                      {{ $user->telephone }}
                    </p>
                  </div>
                  
                  
                </div>

                @if ($user->status === "Active")
                    @if(!$promotions->isEmpty())
                        <div class="card-box">
                            <div class="card-box-header">
                                Promotion
                            </div>
                            <div class="card-box-content">
                                <div class="row">
                                    @foreach($promotions as $promotion)
                                        <div class="col-md-4">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $promotion->name }}</h5>
                                                    <p class="card-text">Code: <strong>{{ $promotion->promotion_code }}</strong></p>
                                                    @if ($promotion->discount_amount)
                                                        <p class="card-text">Discount: <strong>Rp {{ number_format($promotion->discount_amount, 0, ",", ".") }}</strong></p>
                                                    @else
                                                        <p class="card-text">Discount: <strong>{{ $promotion->discount_percent }}%</strong></p>
                                                    @endif
                                                    <div class="card-form text-right">
                                                        <form action="{{ route('promotions.use', $promotion->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary w-100">Use Promotion</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card-box m-b-18">
                    <form action="{{ route('user.updateProfile') }}"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <h4 class="sign-title">Profile details</h4>
                            </div>
                            <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                <div class="form-group">
                                <label for="telephone">Telephone</label>
                                <input type="number" name="telephone" id="telephone" class="form-control" value="{{ $user->telephone }}" required>
                                @error('telephone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            </div>
                            <div class="col-12 text-right">
                                <button class="btn button-secondary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-box">
                    <form method="POST" action="{{ route('profile.updatePassword') }}">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                        <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        @error('current_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    </div>
            
                    <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    </div>
            
                    <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        <span toggle="#password_confirmation" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn button-secondary"><i class="fa-solid fa-floppy-disk"></i> Update Password</button>
                    </div>
                    </div>
                </form>
                </div>
                </div>
            </div>
        @endif
          
        <div class="row">
            <div class="col-12">
                <!-- content tabs -->
                <div class="tab-content">
                    <div class="tab-pane fade  show active" id="tab-3" role="tabpanel">
                        <div class="row">
                            <!-- details form -->
                            
                            <!-- end details form -->

                            <!-- password form -->
                            <div class="col-12 col-lg-6 m-b-18">
                                
                            </div>
                            <!-- end password form -->
                        </div>
                    </div>
                </div>
                <!-- end content tabs -->
            </div>
        </div>
    </div>
    <script>
      // JavaScript untuk toggle password visibility
      document.querySelectorAll('.toggle-password').forEach(item => {
          item.addEventListener('click', function () {
              let input = document.querySelector(this.getAttribute('toggle'));
              if (input.getAttribute('type') === 'password') {
                  input.setAttribute('type', 'text');
                  this.classList.remove('fa-eye');
                  this.classList.add('fa-eye-slash');
              } else {
                  input.setAttribute('type', 'password');
                  this.classList.remove('fa-eye-slash');
                  this.classList.add('fa-eye');
              }
          });
      });
  </script>
@endsection
