  <section class="profile-edit-card profile-edit-reveal">
      <div class="profile-edit-section-heading">
          <div class="profile-edit-section-icon contact">
              <i class="fas fa-address-book"></i>
          </div>

          <div>
              <h5>Contact Information</h5>
              <p>Keep your registered phone numbers up to date.</p>
          </div>
      </div>

      <div class="profile-edit-fields-grid">
          <div class="profile-edit-field">
              <label for="phone">Primary Phone</label>
              <div class="profile-edit-input-wrapper">
                  <i class="fas fa-phone input-icon"></i>
                  <input type="tel" name="phone" id="phone"
                      class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}"
                      placeholder="Enter primary phone" autocomplete="tel">
              </div>

              @error('phone')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
          </div>

          <div class="profile-edit-field">
              <label for="phone_2">Alternative Phone</label>
              <div class="profile-edit-input-wrapper">
                  <i class="fas fa-mobile-alt input-icon"></i>
                  <input type="tel" name="phone_2" id="phone_2"
                      class="form-control @error('phone_2') is-invalid @enderror"
                      value="{{ old('phone_2', $user->phone_2) }}" placeholder="Enter alternative phone">
              </div>

              @error('phone_2')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
          </div>

      </div>
  </section>
