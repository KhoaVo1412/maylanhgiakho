import React, { useState, useEffect, useRef } from 'react';

export default function HeaderApp({ initialData = {} }) {
  const user = initialData.user || null;
  const initialCartCount = Number(initialData.cart_count) || 0;
  const menus = initialData.menus || [];
  const hotline = initialData.hotline || '0583593999';
  const email = initialData.email || 'Phanvanhoa231102@gmail.com';
  const workingHours = initialData.working_hours || 'Thứ 2 - CN';
  const currentPath = (initialData.current_path || window.location.pathname || '').replace(/^\//, '');

  const [cartCount, setCartCount] = useState(initialCartCount);
  const [searchKey, setSearchKey] = useState('');
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [userDropdownOpen, setUserDropdownOpen] = useState(false);
  const [brandsDropdownOpen, setBrandsDropdownOpen] = useState(false);
  const [isScrolled, setIsScrolled] = useState(false);

  const userDropdownRef = useRef(null);
  const brandsDropdownRef = useRef(null);

  // Detect scroll for sticky header elevation
  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 40);
    };
    window.addEventListener('scroll', handleScroll, { passive: true });
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  // Listen for custom cart update events and outside clicks
  useEffect(() => {
    const handleCartUpdate = (e) => {
      if (e.detail && typeof e.detail.count === 'number') {
        setCartCount(e.detail.count);
      }
    };
    window.addEventListener('cart-updated', handleCartUpdate);

    const handleClickOutside = (e) => {
      if (userDropdownRef.current && !userDropdownRef.current.contains(e.target)) {
        setUserDropdownOpen(false);
      }
      if (brandsDropdownRef.current && !brandsDropdownRef.current.contains(e.target)) {
        setBrandsDropdownOpen(false);
      }
    };
    document.addEventListener('mousedown', handleClickOutside);

    return () => {
      window.removeEventListener('cart-updated', handleCartUpdate);
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, []);

  // Handle Search Submission
  const handleSearchSubmit = (e) => {
    e.preventDefault();
    const query = searchKey.trim();
    if (query) {
      window.location.href = `/timkiem?key=${encodeURIComponent(query)}`;
    }
  };

  // Helper to determine active route
  const isActive = (path) => {
    if (!path || path === '/' || path === '') {
      return currentPath === '' || currentPath === '/';
    }
    const clean = path.replace(/^\//, '');
    return currentPath === clean || currentPath.startsWith(clean + '/');
  };

  return (
    <header className={`ac-site-header ${isScrolled ? 'is-sticky' : ''}`}>
      {/* 1. Top Blue Bar */}
      <div className="ac-top-bar">
        <div className="ac-container ac-top-bar-inner">
          {/* Left contact info */}
          <div className="ac-top-contacts">
            <a href={`tel:${hotline}`} className="ac-top-item">
              <span className="ac-top-icon">📞</span>
              <span>{hotline}</span>
            </a>
            <span className="ac-top-sep">•</span>
            <a href={`mailto:${email}`} className="ac-top-item">
              <span className="ac-top-icon">✉️</span>
              <span>{email}</span>
            </a>
            <span className="ac-top-sep">•</span>
            <div className="ac-top-item">
              <span className="ac-top-icon">🕒</span>
              <span>{workingHours}</span>
            </div>
          </div>

          {/* Right: Auth User or Login */}
          <div className="ac-top-auth">
            {user ? (
              <div className="ac-user-dropdown-wrap" ref={userDropdownRef}>
                <button
                  type="button"
                  className="ac-user-btn"
                  onClick={() => setUserDropdownOpen(!userDropdownOpen)}
                >
                  <img
                    src={user.avatar || 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'}
                    alt={user.name}
                    className="ac-user-avatar"
                  />
                  <span className="ac-user-name">{user.name}</span>
                  <span className="ac-arrow-down">▾</span>
                </button>

                {userDropdownOpen && (
                  <div className="ac-user-menu-dropdown">
                    <div className="ac-user-menu-header">
                      <strong>{user.name}</strong>
                      <small>{user.email}</small>
                    </div>
                    <ul className="ac-user-menu-list">
                      <li>
                        <a href="/profile">
                          <span className="ac-mi-icon">👤</span> Thông tin tài khoản
                        </a>
                      </li>
                      <li>
                        <a href="/history_order">
                          <span className="ac-mi-icon">📦</span> Sản phẩm đang mua
                        </a>
                      </li>
                      <li className="ac-menu-divider"></li>
                      <li>
                        <a href="/logout" className="ac-logout-link">
                          <span className="ac-mi-icon">🚪</span> Đăng xuất
                        </a>
                      </li>
                    </ul>
                  </div>
                )}
              </div>
            ) : (
              <a href="/loginuser" className="ac-top-login-link">
                Đăng nhập
              </a>
            )}
          </div>
        </div>
      </div>

      {/* 2. Main Navigation Bar */}
      <div className="ac-main-header">
        <div className="ac-container ac-main-header-inner">
          {/* Logo */}
          <div className="ac-header-logo-col">
            <a href="/" className="ac-header-logo-link" title="Máy Lạnh Giá Kho Phan Hòa">
              <img
                src="/template/images/icons/iconml.png"
                alt="Điện Lạnh Phan Hòa - maylanhgiakho.ai.vn"
                className="ac-header-logo-img"
              />
            </a>
          </div>

          {/* Desktop Navigation Menu */}
          <nav className="ac-desktop-nav">
            <ul className="ac-nav-list">
              <li>
                <a
                  href="/"
                  className={`ac-nav-link ${isActive('/') ? 'active-pill' : ''}`}
                >
                  Trang Chủ
                </a>
              </li>

              {/* Brands dropdown */}
              {menus && menus.length > 0 && (
                <li className="ac-has-dropdown" ref={brandsDropdownRef}>
                  <button
                    type="button"
                    className="ac-nav-link ac-dropdown-trigger"
                    onClick={() => setBrandsDropdownOpen(!brandsDropdownOpen)}
                  >
                    <span>Hãng Máy Lạnh</span>
                    <span className="ac-chevron">▾</span>
                  </button>

                  <div className={`ac-megamenu-dropdown ${brandsDropdownOpen ? 'show' : ''}`}>
                    <div className="ac-megamenu-grid">
                      {menus.map((m) => (
                        <a
                          key={m.id}
                          href={`/danh-muc/${m.slug}`}
                          className="ac-megamenu-item"
                          onClick={() => setBrandsDropdownOpen(false)}
                        >
                          {m.thumb && (
                            <img src={m.thumb.startsWith('/') ? m.thumb : `/${m.thumb}`} alt={m.name} />
                          )}
                          <span>Máy lạnh {m.name}</span>
                        </a>
                      ))}
                    </div>
                  </div>
                </li>
              )}

              <li>
                <a
                  href="/dichvu"
                  className={`ac-nav-link ${isActive('/dichvu') ? 'active-pill' : ''}`}
                >
                  Dịch Vụ
                </a>
              </li>
              {/* <li>
                <a
                  href="/banggia"
                  className={`ac-nav-link ${isActive('/banggia') ? 'active-pill' : ''}`}
                >
                  Bảng Giá Dịch Vụ
                </a>
              </li> */}
              <li>
                <a
                  href="/contact"
                  className={`ac-nav-link ${isActive('/contact') ? 'active-pill' : ''}`}
                >
                  Liên Hệ
                </a>
              </li>
              <li>
                <a
                  href="/tintuc"
                  className={`ac-nav-link ${isActive('/tintuc') ? 'active-pill' : ''}`}
                >
                  Tin Tức
                </a>
              </li>
            </ul>
          </nav>

          {/* Search Box & Cart Icon */}
          <div className="ac-header-actions-col">
            {/* Search Pill Input */}
            <form onSubmit={handleSearchSubmit} className="ac-header-search-form">
              <input
                type="text"
                className="ac-header-search-input"
                placeholder="Tìm kiếm..."
                value={searchKey}
                onChange={(e) => setSearchKey(e.target.value)}
              />
              <button type="submit" className="ac-header-search-btn" title="Tìm kiếm">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.2" strokeLinecap="round" strokeLinejoin="round">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
              </button>
            </form>

            {/* Cart Button */}
            <a
              href="/carts"
              className="ac-header-cart-btn icon-header-noti js-show-cart"
              data-notify={cartCount}
              title="Xem giỏ hàng"
            >
              <svg className="ac-cart-svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
              </svg>
              <span className="ac-cart-badge">{cartCount}</span>
            </a>

            {/* Mobile Hamburger Button */}
            <button
              type="button"
              className="ac-mobile-hamburger"
              onClick={() => setMobileMenuOpen(true)}
              title="Mở menu"
            >
              <span></span>
              <span></span>
              <span></span>
            </button>
          </div>
        </div>
      </div>

      {/* 3. Mobile Slide-Over Drawer */}
      {mobileMenuOpen && (
        <div className="ac-drawer-backdrop" onClick={() => setMobileMenuOpen(false)}>
          <div className="ac-mobile-drawer" onClick={(e) => e.stopPropagation()}>
            <div className="ac-drawer-header">
              <a href="/" className="ac-drawer-logo">
                <img src="/template/images/icons/iconml.png" alt="Logo" />
              </a>
              <button
                type="button"
                className="ac-drawer-close-btn"
                onClick={() => setMobileMenuOpen(false)}
              >
                ✕
              </button>
            </div>

            {/* Mobile Search */}
            <form onSubmit={handleSearchSubmit} className="ac-drawer-search">
              <input
                type="text"
                placeholder="Tìm kiếm máy lạnh..."
                value={searchKey}
                onChange={(e) => setSearchKey(e.target.value)}
              />
              <button type="submit">🔍</button>
            </form>

            {/* Mobile User Section */}
            <div className="ac-drawer-user-box">
              {user ? (
                <div className="ac-drawer-user-info">
                  <img
                    src={user.avatar || 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'}
                    alt={user.name}
                  />
                  <div>
                    <strong>{user.name}</strong>
                    <div className="ac-drawer-user-links">
                      <a href="/profile">Thông tin</a> • <a href="/history_order">Đơn hàng</a> • <a href="/logout">Đăng xuất</a>
                    </div>
                  </div>
                </div>
              ) : (
                <a href="/loginuser" className="ac-drawer-login-btn">
                  <span>👤</span> Đăng nhập tài khoản
                </a>
              )}
            </div>

            {/* Mobile Navigation Links */}
            <ul className="ac-drawer-nav">
              <li>
                <a href="/" className={isActive('/') ? 'active' : ''}>
                  Trang Chủ
                </a>
              </li>
              <li>
                <a href="/dichvu" className={isActive('/dichvu') ? 'active' : ''}>
                  Dịch Vụ Lắp Đặt & Bảo Trì
                </a>
              </li>
              <li>
                <a href="/banggia" className={isActive('/banggia') ? 'active' : ''}>
                  Bảng Giá Dịch Vụ
                </a>
              </li>
              <li>
                <a href="/contact" className={isActive('/contact') ? 'active' : ''}>
                  Liên Hệ
                </a>
              </li>
              <li>
                <a href="/tintuc" className={isActive('/tintuc') ? 'active' : ''}>
                  Tin Tức
                </a>
              </li>
            </ul>

            {/* Brands in Drawer */}
            {menus && menus.length > 0 && (
              <div className="ac-drawer-brands">
                <div className="ac-drawer-brands-title">Danh Mục Hãng Máy Lạnh</div>
                <div className="ac-drawer-brands-grid">
                  {menus.map((m) => (
                    <a key={m.id} href={`/danh-muc/${m.slug}`}>
                      {m.name}
                    </a>
                  ))}
                </div>
              </div>
            )}

            {/* Quick Contacts in Drawer */}
            <div className="ac-drawer-contacts">
              <a href={`tel:${hotline}`} className="ac-drawer-phone">
                <span>📞 Hotline:</span> <strong>{hotline}</strong>
              </a>
              <a href={`https://zalo.me/${hotline}`} target="_blank" rel="noopener noreferrer" className="ac-drawer-zalo">
                <span>💬 Chat Zalo:</span> <strong>{hotline}</strong>
              </a>
            </div>
          </div>
        </div>
      )}
    </header>
  );
}
