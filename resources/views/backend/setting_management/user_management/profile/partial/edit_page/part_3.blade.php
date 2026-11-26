  <div class="profile-edit-form-footer">
      <div class="profile-edit-unsaved-indicator" id="unsavedIndicator">
          <span></span>
          <small>Unsaved changes</small>
      </div>

      <div class="profile-edit-footer-actions">
          <a href="{{ route('user_profile_show') }}" class="profile-edit-cancel-btn" id="cancelProfileEdit">
              Cancel
          </a>

          <button type="submit" class="profile-edit-submit-btn" id="updateProfileBtn">
              <i class="fas fa-save"></i>
              <span>Save Changes</span>
          </button>
      </div>
  </div>
