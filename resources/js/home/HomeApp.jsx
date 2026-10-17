import React, { useState, useMemo } from 'react';
import HeroSection from './components/HeroSection';
import RoomSizeCalculator from './components/RoomSizeCalculator';
import BrandCatalog from './components/BrandCatalog';
import FilterSection from './components/FilterSection';
import ProductCard from './components/ProductCard';
import QuickViewModal from './components/QuickViewModal';
import JapaneseAcSection from './components/JapaneseAcSection';
import InstallationGallery from './components/InstallationGallery';
import CommitmentBanner from './components/CommitmentBanner';
import { extractHP, isInverter, isGasR32, removeVietnameseTones } from './utils';

export default function HomeApp({ initialData = {} }) {
  const [products] = useState(initialData.products || []);
  const [menus] = useState(initialData.menus || []);
  const [sliders] = useState(initialData.sliders || []);

  // Filter States
  const [selectedBrand, setSelectedBrand] = useState(null);
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedHP, setSelectedHP] = useState('');
  const [selectedPriceRange, setSelectedPriceRange] = useState('');
  const [onlyInverter, setOnlyInverter] = useState(false);
  const [onlyGasR32, setOnlyGasR32] = useState(false);
  const [sortBy, setSortBy] = useState('newest');

  // Modal & Pagination States
  const [quickViewProduct, setQuickViewProduct] = useState(null);
  const [visibleCount, setVisibleCount] = useState(24);

  // Compute product count per brand
  const brandCounts = useMemo(() => {
    const counts = {};
    products.forEach((p) => {
      if (p.menu_id) {
        counts[p.menu_id] = (counts[p.menu_id] || 0) + 1;
      }
    });
    return counts;
  }, [products]);

  // Selected brand object
  const activeBrandObj = useMemo(() => {
    if (!selectedBrand) return null;
    return menus.find((m) => String(m.id) === String(selectedBrand)) || null;
  }, [selectedBrand, menus]);

  // Check if any filter is active
  const isFiltered = Boolean(
    selectedBrand ||
    searchTerm.trim() ||
    selectedHP ||
    selectedPriceRange ||
    onlyInverter ||
    onlyGasR32
  );

  const handleClearAllFilters = () => {
    setSelectedBrand(null);
    setSearchTerm('');
    setSelectedHP('');
    setSelectedPriceRange('');
    setOnlyInverter(false);
    setOnlyGasR32(false);
    setSortBy('newest');
    setVisibleCount(24);
  };

  // Filter and sort products
  const filteredProducts = useMemo(() => {
    const qRaw = searchTerm.trim().toLowerCase();
    const qNoTone = removeVietnameseTones(qRaw);

    return products.filter((p) => {
      // 1. Brand filter
      if (selectedBrand && String(p.menu_id) !== String(selectedBrand)) {
        return false;
      }

      // 2. Search keyword (diacritic-aware & tone-insensitive)
      if (qRaw) {
        const textRaw = ((p.name || '') + ' ' + (p.model || '') + ' ' + (p.description || '')).toLowerCase();
        const textNoTone = removeVietnameseTones(textRaw);
        if (!textRaw.includes(qRaw) && !textNoTone.includes(qNoTone)) {
          return false;
        }
      }

      // 3. HP / Capacity filter
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

      // 4. Price range filter
      if (selectedPriceRange) {
        const price = Number(p.price_sale) > 0 ? Number(p.price_sale) : Number(p.price) || 0;
        if (price === 0) return false; // Hide 0/contact prices when filtering by price
        if (selectedPriceRange === 'under-7' && price > 7000000) return false;
        if (selectedPriceRange === '7-9' && (price < 7000000 || price > 9000000)) return false;
        if (selectedPriceRange === '9-12' && (price < 9000000 || price > 12000000)) return false;
        if (selectedPriceRange === '12-15' && (price < 12000000 || price > 15000000)) return false;
        if (selectedPriceRange === 'over-15' && price < 15000000) return false;
      }

      // 5. Inverter filter
      if (onlyInverter && !isInverter(p)) {
        return false;
      }

      // 6. Gas R32 filter (handles R-32, r32, etc.)
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
    selectedBrand,
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
    <div className="ac-app">
      <div className="ac-container">
        {/* Top Trust & Reassurance Ribbon */}
        <section className="ac-trust-bar" aria-label="Cam kết dịch vụ">
          <div className="ac-trust-grid">
            <div className="ac-trust-item">
              <div className="ac-trust-icon">
                <i className="fa fa-shield-alt"></i>
              </div>
              <div className="ac-trust-text">
                <h4>100% Chính Hãng</h4>
                <p>Nguyên đai, mới xuất xưởng</p>
              </div>
            </div>

            <div className="ac-trust-item">
              <div className="ac-trust-icon">
                <i className="fa fa-tags"></i>
              </div>
              <div className="ac-trust-text">
                <h4>Giá Sỉ Tại Kho</h4>
                <p>Rẻ hơn 15 - 25% thị trường</p>
              </div>
            </div>

            <div className="ac-trust-item">
              <div className="ac-trust-icon">
                <i className="fa fa-truck"></i>
              </div>
              <div className="ac-trust-text">
                <h4>Giao Lắp Tận Nơi</h4>
                <p>Hỏa tốc trong vòng 2 giờ</p>
              </div>
            </div>

            <div className="ac-trust-item">
              <div className="ac-trust-icon">
                <i className="fa fa-refresh"></i>
              </div>
              <div className="ac-trust-text">
                <h4>Đổi Mới 30 Ngày</h4>
                <p>Nếu có lỗi từ nhà sản xuất</p>
              </div>
            </div>
          </div>
        </section>

        {/* Hero Banner with Split Brand Navigation */}
        <HeroSection
          sliders={sliders}
          menus={menus}
          selectedBrand={selectedBrand}
          onSelectBrand={(id) => {
            setSelectedBrand(id);
            const el = document.getElementById('danh-sach-san-pham');
            if (el) el.scrollIntoView({ behavior: 'smooth' });
          }}
          brandCounts={brandCounts}
          totalProductsCount={products.length}
        />

        {/* Smart Room Size Capacity Advisor */}
        <RoomSizeCalculator
          onApplyHPFilter={(hp) => {
            setSelectedHP(hp);
            setVisibleCount(24);
          }}
        />

        {/* Brand Catalog Bar */}
        <BrandCatalog
          menus={menus}
          selectedBrand={selectedBrand}
          onSelectBrand={(id) => {
            setSelectedBrand(id);
            setVisibleCount(24);
            const el = document.getElementById('danh-sach-san-pham');
            if (el) el.scrollIntoView({ behavior: 'smooth' });
          }}
          brandCounts={brandCounts}
        />

        {/* Filter Bar with HP, Price, Inverter & Instant Search */}
        <FilterSection
          searchTerm={searchTerm}
          onSearchChange={(val) => {
            setSearchTerm(val);
            setVisibleCount(24);
          }}
          selectedBrand={selectedBrand}
          onSelectBrand={(id) => {
            setSelectedBrand(id);
            setVisibleCount(24);
          }}
          menus={menus}
          brandCounts={brandCounts}
          selectedHP={selectedHP}
          onSelectHP={(hp) => {
            setSelectedHP(hp === selectedHP ? '' : hp);
            setVisibleCount(24);
          }}
          selectedPriceRange={selectedPriceRange}
          onSelectPriceRange={(range) => {
            setSelectedPriceRange(range === selectedPriceRange ? '' : range);
            setVisibleCount(24);
          }}
          onlyInverter={onlyInverter}
          onToggleInverter={() => {
            setOnlyInverter(!onlyInverter);
            setVisibleCount(24);
          }}
          onlyGasR32={onlyGasR32}
          onToggleGasR32={() => {
            setOnlyGasR32(!onlyGasR32);
            setVisibleCount(24);
          }}
          sortBy={sortBy}
          onSortChange={(sort) => {
            setSortBy(sort);
            setVisibleCount(24);
          }}
          totalCount={filteredProducts.length}
          onClearAll={handleClearAllFilters}
          isFiltered={isFiltered}
        />

        {/* Products Grid */}
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
              <i className="fa fa-info-circle" style={{ color: '#0284c7' }}></i>
            </div>
            {activeBrandObj && (brandCounts[activeBrandObj.id] || 0) === 0 ? (
              <>
                <h3 style={{ color: '#0f172a' }}>
                  Hãng "{activeBrandObj.name}" Hiện Đang Tạm Hết Hàng
                </h3>
                <p style={{ maxWidth: 520, margin: '0 auto 20px', color: '#64748b' }}>
                  Hiện tại kho chưa có sản phẩm máy lạnh thuộc hãng {activeBrandObj.name}. Quý khách vui lòng chọn các hãng sẵn hàng như Daikin, Panasonic, Casper, Mitsubishi, Toshiba,...
                </p>
                <button
                  type="button"
                  className="ac-btn-load-more"
                  style={{ background: '#0284c7', color: '#fff', border: 'none' }}
                  onClick={() => setSelectedBrand(null)}
                >
                  <i className="fa fa-th-large"></i>
                  <span>Xem {products.length} Máy Lạnh Thuộc Các Hãng Khác</span>
                </button>
              </>
            ) : (
              <>
                <h3>Không Tìm Thấy Máy Lạnh Phù Hợp</h3>
                <p>
                  Không có sản phẩm nào thỏa mãn tất cả tiêu chí lọc hiện tại. Vui lòng thử đổi công suất hoặc khoảng giá.
                </p>
                <button
                  type="button"
                  className="ac-btn-load-more"
                  onClick={handleClearAllFilters}
                >
                  <i className="fa fa-refresh"></i>
                  <span>Đặt Lại Bộ Lọc Để Xem Toàn Bộ Kho ({products.length} máy)</span>
                </button>
              </>
            )}
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
                Xem Thêm Sản Phẩm (Còn {filteredProducts.length - visibleCount} máy lạnh)
              </span>
            </button>
          </div>
        )}

        {/* Specialized Japanese AC Section */}
        <JapaneseAcSection />

        {/* Real-world Installation Photos */}
        <InstallationGallery />

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
