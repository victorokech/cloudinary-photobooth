<div>
	{{-- Do your work, then step back. --}}
	@if (session()->has('message'))
		<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
			<h4 class="alert-heading">Awesomeness!</h4>
			<p>{{ session('message') }}</p>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@elseif(session()->has('error'))
		<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
			<h4 class="alert-heading">Oops!</h4>
			<p>{{ session('error') }}</p>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif
	<div class="flex h-screen justify-center items-center">
		<div class="row w-75">
			<div class="col-md-12">
				<form class="mb-5" wire:submit.prevent="photoBooth">
					<div class="form-group row mt-5 mb-3">
						<div class="input-group mb-5">
							<select id="effect" type="file" class="form-select @error('effect') is-invalid @enderror"
							        wire:model="effect">
								<option selected>Choose Photo Effect ...</option>
								<option selected value="effect_one">Cloudinary Rocks</option>
								<option value="effect_two">Rose Flower</option>
								<option value="effect_three">Abstract</option>
								<option value="effect_four">Flower Petals</option>
							</select>
							@error('effect')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="input-group">
							<input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror"
							       placeholder="Choose photo..." wire:model="photo">
							
							@error('photo')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<small class="text-muted text-center mt-2" wire:loading wire:target="photo">
							{{ __('Uploading') }}&hellip;
						</small>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-sm btn-primary w-25">
							<i class="fas fa-check mr-1"></i> {{ __('Lights, Camera, Action') }}
							<i class="spinner-border spinner-border-sm ml-1 mt-1" wire:loading wire:target="photoBooth"></i>
						</button>
					</div>
				</form>
			</div>
			<div class="row mt-4">
				@foreach($this->gallery as $galleryItem)
					@if ($galleryItem)
						<div class="col-sm-3 col-md-3 mb-3">
							<img class="card-img-top img-thumbnail img-fluid" src="{{ $galleryItem }}" alt="Virtual Photo Booth"/>
						</div>
					@endif
				@endforeach
			</div>
		</div>
	</div>
</div>
