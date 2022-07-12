<?php
	
	namespace App\Http\Livewire;
	
	use Illuminate\Support\Arr;
	use Livewire\Component;
	use Livewire\WithFileUploads;
	
	class PhotoBooth extends Component {
		use WithFileUploads;
		
		public $photo;
		public $effect;
		public $gallery = [];
		public $effectTransformations;
		public $folder = "photo-booth";
		public $tag = "photo-booth";
		
		public function mount() {
			//fetch files from cloudinary with specific tag
			$result = cloudinary()->search()
				->expression($this->tag)
				->withField('tags')
				->maxResults(12)
				->execute();
			
			foreach ($result['resources'] as $res) {
				$this->gallery[] = $res['secure_url'];
			}
		}
		
		public function photoBooth() {
			$this->validate([
				'effect' => 'required|string',
				'photo'  => [
					'required',
					'image',
					'max:10240'
				]
			]);
			
			// transforming
			$this->effectTransformations = [
				['crop' => 'crop', 'aspect_ratio' => 0.75, 'gravity' => 'faces', 'height' => 1600],
				[
					'overlay' => [
						'public_id' => "$this->folder/assets/$this->effect",
						'flags'     => 'relative',
						'crop'      => 'scale',
						'width'     => 1.0,
						'height'    => 1.0,
					]
				]
			];
			
			//upload to cloudinary
			$photo = cloudinary()->upload($this->photo->getRealPath(), [
				'folder'         => $this->folder,
				'tags'           => $this->tag,
				'transformation' => $this->effectTransformations
			])->getSecurePath();
			
			$this->gallery = Arr::prepend($this->gallery, $photo);
		}
		
		public function render() {
			return view('livewire.photo-booth');
		}
	}
