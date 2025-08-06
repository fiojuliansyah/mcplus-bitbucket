<!-- Watch Button -->
<button type="button"
        class="btn btn-success btn-sm d-flex align-items-center gap-1"
        data-bs-toggle="modal"
        data-bs-target="#videoModal-{{ $row->id }}">
    <i class="fas fa-eye"></i> Watch
</button>

<!-- Modal -->
<div class="modal fade" id="videoModal-{{ $row->id }}" tabindex="-1" aria-labelledby="videoModalLabel-{{ $row->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="videoModalLabel-{{ $row->id }}">Replay Video</h5>
        <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
      </div>
      <div class="modal-body p-0">
        <div class="ratio ratio-16x9">
            <iframe 
                src="https://player.cloudinary.com/embed/?cloud_name=dvtnwsojr&public_id={{ $row->replay_public_id }}" 
                allow="autoplay; fullscreen; encrypted-media; picture-in-picture"
                allowfullscreen
                frameborder="0"
                loading="lazy">
            </iframe>
        </div>
      </div>
    </div>
  </div>
</div>
