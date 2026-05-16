  
  <div class="topbar-image bg-primary py-6 rounded-0 mb-0 alert alert-dismissible fade show" role="alert" style="background: linear-gradient(135deg, var(--bs-primary), #0056b3);">
    <div class="d-flex justify-content-center gap-3 align-items-center flex-nowrap">
      <!-- Animated Text + WhatsApp Button together -->
      <div class="overflow-hidden flex-grow-1">
        <div class="marquee-content text-white" style="font-size: 13px; white-space: nowrap;">
          <i class="bi bi-megaphone-fill me-2"></i>
          <strong>Advertise with Us!</strong>
          <span class="mx-2 text-white-50">|</span>
          <!-- <i class="bi bi-whatsapp me-1"></i> -->
          <!-- <span>Contact us on <strong>+256 754 428612</strong></span> -->
          <!-- <span class="mx-2 text-white-50">|</span> -->
          <a href="https://wa.me/256754428612?text=Hello%21%20I%27m%20interested%20in%20advertising%20on%20Stardena%20Works." 
            target="_blank" 
            class="btn btn-success btn-sm rounded-pill px-2 py-0" 
            style="background: #25D366; border: none; font-size: 11px; display: inline-block; margin: 0 4px;">
              <i class="bi bi-whatsapp me-1"></i> Advertise Now
          </a>
          <span class="mx-2 text-white-50">|</span>
          <i class="bi bi-graph-up me-1"></i>
          <span>Over <strong>50,000+ monthly visitors</strong></span>
          <span class="mx-2 text-white-50">|</span>
          <i class="bi bi-eye-fill me-1"></i>
          <span>Get maximum exposure for your job advert and brand</span>
        </div>
      </div>
      
      <!-- Close Button -->
      <button type="button" class="btn-close btn-close-white flex-shrink-0" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>

  <style>
      .marquee-content {
          display: inline-block;
          white-space: nowrap;
          animation: marqueeScroll 40s linear infinite;
      }
      
      .topbar-image:hover .marquee-content {
          animation-play-state: paused;
      }
      
      @keyframes marqueeScroll {
          0% { transform: translateX(0); }
          100% { transform: translateX(-50%); }
      }
      
      @media (max-width: 768px) {
          .marquee-content {
              font-size: 10px !important;
              animation-duration: 30s;
          }
          .marquee-content .btn {
              font-size: 9px !important;
              padding: 2px 6px !important;
          }
      }
  </style>

  <script>
      (function() {
          const marquee = document.querySelector('.marquee-content');
          if (marquee) {
              const content = marquee.innerHTML;
              marquee.innerHTML = content + content;
          }
      })();
  </script>