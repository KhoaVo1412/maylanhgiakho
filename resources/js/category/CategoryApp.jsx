import React, { useState, useMemo } from 'react';
import ProductCard from '../home/components/ProductCard';
import QuickViewModal from '../home/components/QuickViewModal';
import RoomSizeCalculator from '../home/components/RoomSizeCalculator';
import CommitmentBanner from '../home/components/CommitmentBanner';
import { extractHP, isInverter, isGasR32, removeVietnameseTones } from '../home/utils';

export default function CategoryApp({ initialData = {} }) {
  const menu = initialData.menu || {};
  const [products] = useState(initialData.products || []);
  const [menus] = useState(initialData.menus || []);

  // Filter States
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedHP, setSelectedHP] = useState('');
  const [selectedPriceRange, setSelectedPriceRange] = useState('');
  const [onlyInverter, setOnlyInverter] = useState(false);
  const [onlyGasR32, setOnlyGasR32] = useState(false);
  const [sortBy, setSortBy] = useState('newest');

  // Modal & Pagination States
  const [quickViewProduct, setQuickViewProduct] = useState(null);
  const [visibleCount, setVisibleCount] = useState(24);
  const [isContentExpanded, setIsContentExpanded] = useState(false);

  // Check if any filter is active
  const isFiltered = Boolean(
    searchTerm.trim() ||
    selectedHP ||
    selectedPriceRange ||
    onlyInverter ||
    onlyGasR32
  );

  const handleClearAllFilters = () => {
    setSearchTerm('');
    setSelectedHP('');
    setSelectedPriceRange('');
    setOnlyInverter(false);
    setOnlyGasR32(false);
    setSortBy('newest');
    setVisibleCount(24);
  };

  const hpOptions = [
    { label: 'Tất cả công suất', value: '' },
    { label: '1.0 HP', sub: '< 15m²', value: '1.0 HP' },
    { label: '1.5 HP', sub: '15-20m²', value: '1.5 HP' },
    { label: '2.0 HP', sub: '20-30m²', value: '2.0 HP' },
    { label: '2.5 HP', sub: '30-40m²', value: '2.5 HP' },
    { label: '≥ 3.0 HP', sub: '> 40m²', value: '≥ 3.0 HP' },
  ];

  const priceOptions = [
    { label: 'Mọi mức giá', value: '' },
    { label: 'Dưới 7 triệu', min: 0, max: 7000000, value: 'under-7' },
    { label: '7tr - 9 triệu', min: 7000000, max: 9000000, value: '7-9' },
    { label: '9tr - 12 triệu', min: 9000000, max: 12000000, value: '9-12' },
    { label: '12tr - 15 triệu', min: 12000000, max: 15000000, value: '12-15' },
    { label: 'Trên 15 triệu', min: 15000000, max: 999999999, value: 'over-15' },
  ];

  // Filter and sort products
  const filteredProducts = useMemo(() => {
    const qRaw = searchTerm.trim().toLowerCase();
    const qNoTone = removeVietnameseTones(qRaw);

    return products.filter((p) => {
      // 1. Search keyword (diacritic-aware & tone-insensitive)
      if (qRaw) {
        const textRaw = ((p.name || '') + ' ' + (p.model || '') + ' ' + (p.description || '')).toLowerCase();
        const textNoTone = removeVietnameseTones(textRaw);
        if (!textRaw.includes(qRaw) && !textNoTone.includes(qNoTone)) {
          return false;
        }
      }

      // 2. HP / Capacity filter
      if (selectedHP) {
        const hp = extractHP(p);
        if (selectedHP === '≥ 3.0 HP') {
          if (!hp.includes('3') && !hp.includes('4') && !hp.includes('5')) {
            return false;
          }
        } else if (hp !== selectedHP) {
          return false;
        }
      }

      // 3. Price range filter
      if (selectedPriceRange) {
        const price = Number(p.price_sale) > 0 ? Number(p.price_sale) : Number(p.price) || 0;
        if (price === 0) return false; // Hide 0/contact prices when filtering by price
        if (selectedPriceRange === 'under-7' && price > 7000000) return false;
        if (selectedPriceRange === '7-9' && (price < 7000000 || price > 9000000)) return false;
        if (selectedPriceRange === '9-12' && (price < 9000000 || price > 12000000)) return false;
        if (selectedPriceRange === '12-15' && (price < 12000000 || price > 15000000)) return false;
        if (selectedPriceRange === 'over-15' && price < 15000000) return false;
      }

      // 4. Inverter filter
      if (onlyInverter && !isInverter(p)) {
        return false;
      }

      // 5. Gas R32 filter (handles R-32, r32, etc.)
      if (onlyGasR32 && !isGasR32(p)) {
        return false;
      }

      return true;
    }).sort((a, b) => {
      const priceA = Number(a.price_sale) > 0 ? Number(a.price_sale) : Number(a.price) || 0;
      const priceB = Number(b.price_sale) > 0 ? Number(b.price_sale) : Number(b.price) || 0;

      if (sortBy === 'price-asc') {
        if (priceA === 0) return 1;
        if (priceB === 0) return -1;
        return priceA - priceB;
      }
      if (sortBy === 'price-desc') return priceB - priceA;
      if (sortBy === 'views') return (Number(b.view) || 0) - (Number(a.view) || 0);
      return (Number(b.id) || 0) - (Number(a.id) || 0); // newest
    });
  }, [
    products,
    searchTerm,
    selectedHP,
    selectedPriceRange,
    onlyInverter,
    onlyGasR32,
    sortBy,
  ]);

  const displayedProducts = filteredProducts.slice(0, visibleCount);
  const hasMore = visibleCount < filteredProducts.length;

  return (
    <div className="ac-app" style={{ paddingTop: 20 }}>
      <div className="ac-container">
        {/* Breadcrumb Navigation */}
        <nav aria-label="breadcrumb" style={{ margin: '10px 0 20px', fontSize: 13, color: '#64748b' }}>
          <a href="/" style={{ color: '#0284c7', textDecoration: 'none', fontWeight: 600 }}>
            <i className="fa fa-home" style={{ marginRight: 5 }}></i> Trang Chủ
          </a>
          <span style={{ margin: '0 8px', color: '#cbd5e1' }}>/</span>
          <span>Danh Mục Máy Lạnh</span>
          <span style={{ margin: '0 8px', color: '#cbd5e1' }}>/</span>
          <span style={{ color: '#0f172a', fontWeight: 700 }}>Máy Lạnh {menu.name}</span>
        </nav>

        {/* Category Header Hero Card */}
        <section
          style={{
            background: 'linear-gradient(135deg, #0f172a 0%, #1e293b 100%)',
            color: '#ffffff',
            borderRadius: 20,
            padding: '30px',
            marginBottom: '25px',
            boxShadow: '0 10px 25px rgba(0,0,0,0.1)',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'space-between',
            flexWrap: 'wrap',
            gap: 20,
          }}
        >
          <div style={{ maxWidth: 650 }}>
            <span
              style={{
                display: 'inline-block',
                background: 'linear-gradient(135deg, #0284c7 0%, #0369a1 100%)',
                color: '#fff',
                fontSize: 11,
                fontWeight: 800,
                padding: '4px 12px',
                borderRadius: 20,
                textTransform: 'uppercase',
                letterSpacing: 0.5,
                marginBottom: 10,
              }}
            >
              PHÂN PHỐI CHÍNH HÃNG TẠI KHO
            </span>
            <h1 style={{ fontSize: 26, fontWeight: 900, color: '#ffffff', margin: '0 0 10px' }}>
              Máy Lạnh {menu.name} Giá Sỉ Tại Kho
            </h1>
            <p style={{ fontSize: 14, color: '#94a3b8', margin: '0 0 16px', lineHeight: 1.5 }}>
              {menu.description || `Tổng kho cung cấp đầy đủ các dòng máy lạnh ${menu.name} 1HP, 1.5HP, 2HP, 2.5HP Inverter tiết kiệm điện. Cam kết mới 100% nguyên đai nguyên kiện, bảo hành chính hãng tận nơi.`}
            </p>
            <div style={{ display: 'flex', gap: 15, flexWrap: 'wrap' }}>
              <span style={{ fontSize: 12.5, color: '#38bdf8', display: 'flex', alignItems: 'center', gap: 5 }}>
                <i className="fa fa-check-circle"></i> Sẵn sàng giao ngay trong 2H
              </span>
              <span style={{ fontSize: 12.5, color: '#38bdf8', display: 'flex', alignItems: 'center', gap: 5 }}>
                <i className="fa fa-shield-alt"></i> Bảo hành chính hãng {menu.name}
              </span>
              <span style={{ fontSize: 12.5, color: '#38bdf8', display: 'flex', alignItems: 'center', gap: 5 }}>
                <i className="fa fa-tags"></i> Giá rẻ hơn siêu thị 15-25%
              </span> 
            </div>
          </div>

          {menu.thumb && (
            <div
              style={{
                background: '#ffffff',
                padding: 15,
                borderRadius: 14,
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                boxShadow: '0 4px 14px rgba(0,0,0,0.2)',
                maxWidth: 180,
              }}
            >
              <img
                src={menu.thumb}
                alt={`Máy lạnh ${menu.name}`}
                style={{ maxHeight: 60, maxWidth: 150, objectFit: 'contain' }}
              />
            </div>
          )}
        </section>

        {/* Quick Brand Switcher */}
        <div style={{ marginBottom: 25 }}>
          <div style={{ fontSize: 13, fontWeight: 700, color: '#64748b', marginBottom: 10 }}>
            CHUYỂN NHANH SANG THƯƠNG HIỆU KHÁC:
          </div>
          <div style={{ display: 'flex', gap: 8, overflowX: 'auto', paddingBottom: 6 }}>
            {menus.map((m) => {
              const isCurrent = String(m.id) === String(menu.id);
              return (
                <a
                  key={m.id}
                  href={`/danh-muc/${m.slug}`}
                  style={{
                    background: isCurrent ? '#0284c7' : '#ffffff',
                    color: isCurrent ? '#ffffff' : '#334155',
                    border: isCurrent ? '1.5px solid #0284c7' : '1px solid #cbd5e1',
                    padding: '6px 14px',
                    borderRadius: 20,
                    fontSize: 13,
                    fontWeight: isCurrent ? 700 : 500,
                    textDecoration: 'none',
                    whiteSpace: 'nowrap',
                    transition: 'all 0.2s',
                    boxShadow: isCurrent ? '0 2px 8px rgba(2, 132, 199, 0.3)' : 'none',
                  }}
                >
                  Máy lạnh {m.name}
                </a>
              );
            })}
          </div>
        </div>

        {/* Smart Room Size Capacity Advisor */}
        <RoomSizeCalculator
          onApplyHPFilter={(hp) => {
            setSelectedHP(hp);
            setVisibleCount(24);
          }}
        />

        {/* Filter Bar for Category */}
        <div className="ac-catalog-header" id="danh-sach-san-pham">
          <div className="ac-catalog-top-row">
            <h2 className="ac-catalog-title">
              <span>Danh Sách Máy Lạnh {menu.name}</span>
              <span className="count-badge">{filteredProducts.length} sản phẩm sẵn có</span>
            </h2>

            <div className="ac-catalog-search-wrap">
              <i className="fa fa-search"></i>
              <input
                type="text"
                className="ac-catalog-search-input"
                placeholder={`Tìm model máy lạnh ${menu.name}...`}
                value={searchTerm}
                onChange={(e) => {
                  setSearchTerm(e.target.value);
                  setVisibleCount(24);
                }}
              />
            </div>
          </div>

          {/* Active Filter Tags */}
          {isFiltered && (
            <div className="ac-active-tags-bar">
              <span className="ac-active-tags-label">
                <i className="fa fa-filter"></i> Đang lọc:
              </span>

              {selectedHP && (
                <span className="ac-active-tag">
                  Công suất: {selectedHP}
                  <button type="button" onClick={() => setSelectedHP('')}>✕</button>
                </span>
              )}

              {selectedPriceRange && (
                <span className="ac-active-tag">
                  Giá: {priceOptions.find(p => p.value === selectedPriceRange)?.label}
                  <button type="button" onClick={() => setSelectedPriceRange('')}>✕</button>
                </span>
              )}

              {onlyInverter && (
                <span className="ac-active-tag">
                  Inverter Tiết Kiệm Điện
                  <button type="button" onClick={() => setOnlyInverter(false)}>✕</button>
                </span>
              )}

              {onlyGasR32 && (
                <span className="ac-active-tag">
                  Gas R32
                  <button type="button" onClick={() => setOnlyGasR32(false)}>✕</button>
                </span>
              )}

              {searchTerm.trim() && (
                <span className="ac-active-tag">
                  Từ khóa: "{searchTerm}"
                  <button type="button" onClick={() => setSearchTerm('')}>✕</button>
                </span>
              )}

              <button
                type="button"
                className="ac-clear-btn"
                style={{ marginLeft: 'auto' }}
                onClick={handleClearAllFilters}
              >
                <i className="fa fa-refresh"></i> Đặt lại bộ lọc
              </button>
            </div>
          )}

          {/* Filter 1: HP */}
          <div className="ac-filter-group">
            <div className="ac-filter-label">
              <i className="fa fa-tachometer" style={{ color: '#0284c7' }}></i>
              <span>Công suất:</span>
            </div>
            <div className="ac-filter-chips">
              {hpOptions.map((opt) => {
                const isActive = selectedHP === opt.value;
                return (
                  <button
                    key={opt.value}
                    type="button"
                    className={`ac-chip ${isActive ? 'active' : ''}`}
                    onClick={() => {
                      setSelectedHP(opt.value === selectedHP ? '' : opt.value);
                      setVisibleCount(24);
                    }}
                  >
                    <span>{opt.label}</span>
                    {opt.sub && <span className="ac-chip-sub">({opt.sub})</span>}
                  </button>
                );
              })}
            </div>
          </div>

          {/* Filter 2: Price */}
          <div className="ac-filter-group">
            <div className="ac-filter-label">
              <i className="fa fa-tags" style={{ color: '#ef4444' }}></i>
              <span>Mức giá:</span>
            </div>
            <div className="ac-filter-chips">
              {priceOptions.map((opt) => {
                const isActive = selectedPriceRange === opt.value;
                return (
                  <button
                    key={opt.value}
                    type="button"
                    className={`ac-chip ${isActive ? 'active' : ''}`}
                    onClick={() => {
                      setSelectedPriceRange(opt.value === selectedPriceRange ? '' : opt.value);
                      setVisibleCount(24);
                    }}
                  >
                    {opt.label}
                  </button>
                );
              })}
            </div>
          </div>

          {/* Filter 3: Tech & Sorting */}
          <div className="ac-catalog-sort-row">
            <div style={{ display: 'flex', alignItems: 'center', gap: 10, flexWrap: 'wrap' }}>
              <button
                type="button"
                className={`ac-chip ${onlyInverter ? 'active' : ''}`}
                onClick={() => setOnlyInverter(!onlyInverter)}
              >
                <i className="fa fa-leaf" style={{ color: onlyInverter ? '#fff' : '#16a34a' }}></i>
                <span>Inverter Tiết Kiệm Điện</span>
              </button>

              <button
                type="button"
                className={`ac-chip ${onlyGasR32 ? 'active' : ''}`}
                onClick={() => setOnlyGasR32(!onlyGasR32)}
              >
                <i className="fa fa-tint" style={{ color: onlyGasR32 ? '#fff' : '#0284c7' }}></i>
                <span>Gas R32 Mới Nhất</span>
              </button>
            </div>

            <div style={{ display: 'flex', alignItems: 'center', gap: 6 }}>
              <span style={{ fontSize: 13, color: '#64748b' }}>Sắp xếp:</span>
              <select
                className="ac-sort-select"
                value={sortBy}
                onChange={(e) => setSortBy(e.target.value)}
              >
                <option value="newest">Mới nhất tại kho</option>
                <option value="price-asc">Giá: Thấp đến Cao</option>
                <option value="price-desc">Giá: Cao đến Thấp</option>
                <option value="views">Xem nhiều nhất</option>
              </select>
            </div>
          </div>
        </div>

        {/* Product Grid */}
        {displayedProducts.length > 0 ? (
          <div className="ac-product-grid">
            {displayedProducts.map((product) => (
              <ProductCard
                key={product.id}
                product={product}
                onQuickView={setQuickViewProduct}
              />
            ))}
          </div>
        ) : (
          <div className="ac-empty-state">
            <div className="ac-empty-icon">
              <i className="fa fa-search-minus"></i>
            </div>
            <h3>Không Tìm Thấy Máy Lạnh {menu.name} Phù Hợp</h3>
            <p>
              Không có sản phẩm nào của {menu.name} thỏa mãn tất cả tiêu chí lọc hiện tại. Vui lòng thử chọn công suất hoặc mức giá khác.
            </p>
            <button
              type="button"
              className="ac-btn-load-more"
              onClick={handleClearAllFilters}
            >
              <i className="fa fa-refresh"></i>
              <span>Xem Toàn Bộ Máy Lạnh {menu.name} ({products.length} máy)</span>
            </button>
          </div>
        )}

        {/* Load More Button */}
        {hasMore && (
          <div className="ac-load-more-wrap">
            <button
              type="button"
              className="ac-btn-load-more"
              onClick={() => setVisibleCount((prev) => prev + 24)}
            >
              <i className="fa fa-plus-circle"></i>
              <span>
                Xem Thêm Sản Phẩm (Còn {filteredProducts.length - visibleCount} máy)
              </span>
            </button>
          </div>
        )}

        {/* Category SEO Article Content */}
        {menu.content && (
          <section
            style={{
              background: '#ffffff',
              border: '1px solid #e2e8f0',
              borderRadius: 20,
              padding: '30px',
              margin: '40px 0',
              boxShadow: '0 1px 3px rgba(0,0,0,0.05)',
            }}
          >
            <h3 style={{ fontSize: 20, fontWeight: 800, color: '#0f172a', marginBottom: 16 }}>
              <i className="fa fa-info-circle" style={{ color: '#0284c7', marginRight: 8 }}></i>
              Giới Thiệu & Đánh Giá Máy Lạnh {menu.name}
            </h3>

            <div
              style={{
                maxHeight: isContentExpanded ? 'none' : '260px',
                overflow: 'hidden',
                position: 'relative',
                lineHeight: 1.7,
                color: '#334155',
                fontSize: 14.5,
                transition: 'max-height 0.4s ease',
              }}
              dangerouslySetInnerHTML={{ __html: menu.content }}
            />

            {!isContentExpanded && (
              <div
                style={{
                  position: 'relative',
                  marginTop: -60,
                  height: 60,
                  background: 'linear-gradient(to bottom, rgba(255,255,255,0), #ffffff)',
                  pointerEvents: 'none',
                }}
              />
            )}

            <div style={{ textAlign: 'center', marginTop: 15 }}>
              <button
                type="button"
                className="ac-slide-btn"
                style={{
                  background: '#f1f5f9',
                  color: '#0284c7',
                  border: '1.5px solid #cbd5e1',
                  boxShadow: 'none',
                  cursor: 'pointer',
                  padding: '8px 24px',
                  fontSize: 13,
                }}
                onClick={() => setIsContentExpanded(!isContentExpanded)}
              >
                <span>{isContentExpanded ? 'Thu Gọn Bài Viết' : 'Đọc Thêm Đánh Giá'}</span>
                <i className={`fa ${isContentExpanded ? 'fa-angle-up' : 'fa-angle-down'}`}></i>
              </button>
            </div>
          </section>
        )}

        {/* 4 Gold Commitments */}
        <CommitmentBanner />
      </div>

      {/* Quick View Modal */}
      {quickViewProduct && (
        <QuickViewModal
          product={quickViewProduct}
          onClose={() => setQuickViewProduct(null)}
        />
      )}
    </div>
  );
}
