import React, { useState, useEffect, useMemo } from 'react';

export default function HeroSection({
  sliders = [],
  menus = [],
  selectedBrand,
  onSelectBrand,
  brandCounts = {},
  totalProductsCount = 0,
}) {
  const [currentSlide, setCurrentSlide] = useState(0);

  // Auto rotate banner every 5 seconds
  useEffect(() => {
    if (sliders.length <= 1) return;
    const interval = setInterval(() => {
      setCurrentSlide((prev) => (prev + 1) % sliders.length);
    }, 5000);
    return () => clearInterval(interval);
  }, [sliders.length]);

  const activeSlider = sliders[currentSlide] || {
    thumb: '/template/images/slide-01.jpg',
    name: 'Máy Lạnh Chính Hãng Giá Sỉ Tại Kho',
    url: '#danh-sach-san-pham',
  };

  // Sort menus: brands with available products come first, then alphabetically
  const sortedMenus = useMemo(() => {
    return [...menus].sort((a, b) => {
      const countA = brandCounts[a.id] || 0;
      const countB = brandCounts[b.id] || 0;
      if (countA > 0 && countB === 0) return -1;
      if (countA === 0 && countB > 0) return 1;
      return countB - countA;
    });
  }, [menus, brandCounts]);

  return (
    <div className="ac-hero-wrap">
      {/* Left Brand Navigation Sidebar - Links directly to category pages */}
      <aside className="ac-hero-brands">
        <div className="ac-hero-brands-header">
          <i className="fa fa-snowflake-o"></i>
          <span>DANH MỤC THƯƠNG HIỆU</span>
        </div>
        <ul className="ac-hero-brands-list">
          <li>
            <a
              href="#danh-sach-san-pham"
              className={`ac-hero-brand-item ${!selectedBrand ? 'active' : ''}`}
              onClick={(e) => {
                if (onSelectBrand) {
                  onSelectBrand(null);
                }
              }}
            >
              <span>Tất cả thương hiệu</span>
              <span className="brand-count-pill">{totalProductsCount} máy</span>
            </a>
          </li>
          {sortedMenus.slice(0, 10).map((menu) => {
            const count = brandCounts[menu.id] || 0;
            const isSelected = String(selectedBrand) === String(menu.id);
            return (
              <li key={menu.id}>
                <a
                  href={`/danh-muc/${menu.slug}`}
                  className={`ac-hero-brand-item ${isSelected ? 'active' : ''}`}
                  title={`Xem toàn bộ máy lạnh ${menu.name}`}
                >
                  <span>Máy lạnh {menu.name}</span>
                  <div style={{ display: 'flex', alignItems: 'center', gap: 6 }}>
                    <span className={`brand-count-pill ${count === 0 ? 'empty' : ''}`}>
                      {count > 0 ? `${count} máy` : 'Tạm hết'}
                    </span>
                    <i className="fa fa-angle-right" style={{ opacity: 0.5 }}></i>
                  </div>
                </a>
              </li>
            );
          })}
        </ul>
      </aside>

      {/* Main Promo Carousel */}
      <div className="ac-hero-slider">
        <div
          className="ac-slide-item"
          style={{
            backgroundImage: `url(${activeSlider.thumb})`,
          }}
        >
          <div className="ac-slide-overlay"></div>
          <div className="ac-slide-content">
            <span className="ac-slide-badge">
              <i className="fa fa-bolt" style={{ marginRight: 6 }}></i>
              GIÁ SỈ TẬN KHO - RẺ HƠN 15-25%
            </span>
            <h1 className="ac-slide-title">
              {activeSlider.name || 'Tổng Kho Máy Lạnh Chính Hãng Toàn Quốc'}
            </h1>
            <p className="ac-slide-desc">
              Cam kết 100% nguyên đai nguyên kiện, mới xuất xưởng. Đổi mới trong 30 ngày nếu phát sinh lỗi kỹ thuật.
            </p>
            <a href={activeSlider.url || '#danh-sach-san-pham'} className="ac-slide-btn">
              <span>Khám Phá Giá Kho Ngay</span>
              <i className="fa fa-arrow-right"></i>
            </a>
          </div>
        </div>

        {/* Carousel indicators */}
        {sliders.length > 1 && (
          <div className="ac-slider-dots">
            {sliders.map((_, idx) => (
              <button
                key={idx}
                type="button"
                className={`ac-slider-dot ${idx === currentSlide ? 'active' : ''}`}
                onClick={() => setCurrentSlide(idx)}
                aria-label={`Slide ${idx + 1}`}
              ></button>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}
