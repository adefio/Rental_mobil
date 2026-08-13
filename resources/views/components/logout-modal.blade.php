<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="logout-modal-icon mb-2">
                    <x-icon name="log-out" />
                </div>
                <h5 class="fw-bold mb-1" id="logoutModalLabel">Apakah kamu yakin?</h5>
                <p class="text-muted small mb-4">Anda akan keluar dari akun ini.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">Tidak</button>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger px-3">Ya, Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
