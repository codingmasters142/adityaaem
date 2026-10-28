document.addEventListener('DOMContentLoaded', function () {
  const navToggle = document.querySelector('.nav-toggle');
  const mainNav = document.querySelector('.main-nav');
  const header = document.querySelector('.site-header');

  if (navToggle && mainNav) {
    navToggle.addEventListener('click', function () {
      const isOpen = mainNav.classList.toggle('open');
      navToggle.setAttribute('aria-expanded', String(isOpen));
      document.body.classList.toggle('nav-open', isOpen);
    });

    mainNav.querySelector('[data-nav-close]')?.addEventListener('click', function () {
      mainNav.classList.remove('open');
      navToggle.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('nav-open');
      navToggle.focus();
    });

    mainNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mainNav.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('nav-open');
      });
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && mainNav.classList.contains('open')) {
        mainNav.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('nav-open');
      }
    });
  }

  document.querySelectorAll('.sub-toggle').forEach(function (toggle) {
    const item = toggle.closest('.has-sub');
    toggle.addEventListener('click', function (event) {
      event.stopPropagation();
      const isOpen = item.classList.toggle('open');
      toggle.setAttribute('aria-expanded', String(isOpen));
    });
    document.addEventListener('click', function (event) {
      if (!item.contains(event.target) && item.classList.contains('open')) {
        item.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
      }
    });
    item.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && item.classList.contains('open')) {
        item.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
      }
    });
  });

  if (header) {
    const onScroll = function () {
      header.classList.toggle('scrolled', window.scrollY > 12);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  document.querySelectorAll('.faq-question').forEach(function (button) {
    button.addEventListener('click', function () {
      const item = button.closest('.faq-item');
      const isOpen = item.classList.contains('active');
      const list = item.parentElement;
      list.querySelectorAll('.faq-item').forEach(function (faqItem) {
        faqItem.classList.remove('active');
        faqItem.querySelector('.faq-question')?.setAttribute('aria-expanded', 'false');
      });
      if (!isOpen) {
        item.classList.add('active');
        button.setAttribute('aria-expanded', 'true');
      }
    });
  });

  document.querySelectorAll('.filter-chip').forEach(function (chip) {
    chip.addEventListener('click', function () {
      const filter = chip.dataset.filter;
      const grid = document.querySelector('[data-filter-grid]');
      if (!grid) return;
      document.querySelectorAll('.filter-chip').forEach(function (button) {
        button.classList.toggle('active', button === chip);
        button.setAttribute('aria-pressed', String(button === chip));
      });
      grid.querySelectorAll('[data-category]').forEach(function (item) {
        const match = filter === 'all' || item.dataset.category === filter;
        item.style.display = match ? '' : 'none';
      });
    });
  });

  const lightbox = document.querySelector('.gallery-lightbox');
  const lightboxImage = document.querySelector('[data-lightbox-image]');
  const lightboxCaption = document.querySelector('[data-lightbox-caption]');
  const galleryItems = document.querySelectorAll('[data-gallery-item]');
  const images = Array.from(galleryItems).map(function (item) {
    return {
      src: item.dataset.src,
      title: item.dataset.title
    };
  });
  let currentIndex = 0;

  const openLightbox = function (index) {
    if (!lightbox || !lightboxImage || !images.length) return;
    currentIndex = index;
    const item = images[currentIndex];
    lightboxImage.src = item.src;
    lightboxImage.alt = item.title;
    lightboxCaption.textContent = item.title;
    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';
  };

  const closeLightbox = function () {
    if (!lightbox) return;
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
  };

  galleryItems.forEach(function (item, index) {
    item.addEventListener('click', function () {
      openLightbox(index);
    });
  });

  document.querySelector('[data-lightbox-prev]')?.addEventListener('click', function () {
    currentIndex = currentIndex === 0 ? images.length - 1 : currentIndex - 1;
    openLightbox(currentIndex);
  });

  document.querySelector('[data-lightbox-next]')?.addEventListener('click', function () {
    currentIndex = (currentIndex + 1) % images.length;
    openLightbox(currentIndex);
  });

  document.querySelector('[data-lightbox-close]')?.addEventListener('click', closeLightbox);
  lightbox?.addEventListener('click', function (event) {
    if (event.target === lightbox) closeLightbox();
  });

  document.addEventListener('keydown', function (event) {
    if (!lightbox || !lightbox.classList.contains('open')) return;
    if (event.key === 'Escape') closeLightbox();
    if (event.key === 'ArrowRight') {
      currentIndex = (currentIndex + 1) % images.length;
      openLightbox(currentIndex);
    }
    if (event.key === 'ArrowLeft') {
      currentIndex = currentIndex === 0 ? images.length - 1 : currentIndex - 1;
      openLightbox(currentIndex);
    }
  });
});

// Brochure download: collect name + contact number, email the lead, then download
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('brochure-modal');
  if (!modal || typeof modal.showModal !== 'function') return;
  const form = modal.querySelector('.brochure-form');
  const status = modal.querySelector('.brochure-status');
  const submit = form.querySelector('button[type="submit"]');

  const setStatus = function (text, type) {
    status.textContent = text;
    status.className = 'brochure-status' + (type ? ' is-' + type : '');
  };

  document.querySelectorAll('[data-brochure-open]').forEach(function (link) {
    link.addEventListener('click', function (event) {
      event.preventDefault();
      setStatus('');
      modal.showModal();
      form.querySelector('input[name="name"]').focus();
    });
  });

  modal.querySelector('[data-brochure-close]').addEventListener('click', function () { modal.close(); });
  modal.addEventListener('click', function (event) {
    if (event.target === modal) modal.close();
  });

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    const name = form.elements.name.value.trim();
    const phone = form.elements.phone.value.trim();
    const digits = phone.replace(/\D/g, '');
    if (!name) { setStatus('Please enter your name.', 'error'); form.elements.name.focus(); return; }
    if (!/^\+?[\d\s\-()]{7,20}$/.test(phone) || digits.length < 10 || digits.length > 15) {
      setStatus('Please enter a valid contact number.', 'error'); form.elements.phone.focus(); return;
    }

    const data = new FormData(form);
    data.append('page', window.location.href);
    submit.disabled = true;
    setStatus('Sending…');

    fetch(form.action, { method: 'POST', body: data, headers: { Accept: 'application/json' } })
      .then(function (response) { return response.json(); })
      .then(function (result) {
        if (!result.ok) { setStatus(result.message || 'Something went wrong. Please try again.', 'error'); return; }
        setStatus(result.message, 'success');
        const download = document.createElement('a');
        download.href = result.url;
        download.download = result.filename || '';
        document.body.appendChild(download);
        download.click();
        download.remove();
        form.reset();
        setTimeout(function () { modal.close(); }, 1800);
      })
      .catch(function () { setStatus('Something went wrong. Please try again.', 'error'); })
      .finally(function () { submit.disabled = false; });
  });
});
