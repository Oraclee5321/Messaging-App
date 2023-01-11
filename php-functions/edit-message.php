<?php
    echo'
        <div class="modal fade" id="editMessageModal" tabindex="-1" aria-labelledby="editMessageModalLabel" aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editMessageModalLabel">New Message</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">
    
                                <textarea class="form-control" maxlength="256" minlength="1" id="messageInput" name="editMessageInput"></textarea>
                                <span class="input-group-text" id="charCounter"> / 256</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Edit" name="editMessageButton" data-bs-dismiss="modal">
                      </div>
                </div>
            </div>
        </div>'
?>