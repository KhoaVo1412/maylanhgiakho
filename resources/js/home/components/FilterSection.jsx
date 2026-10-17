import React, { useMemo } from 'react';

// Helper to format brand display names cleanly
function formatBrandName(name = '') {
  return name
    .replace(/^DANH MỤC\s*/i, '')
    .replace(/^Máy lạnh\s*/i, '')
    .replace(/\s*THAILAN$/i, '')
    .trim();
}

export default function FilterSection({
  searchTerm,
  onSearchChange,
  selectedBrand,
  onSelectBrand,
  menus = [],
  brandCounts = {},
  selectedHP,
  onSelectHP,
  selectedPriceRange,
  onSelectPriceRange,
  onlyInverter,
  onToggleInverter,
  onlyGasR32,
  onToggleGasR32,
  sortBy,
  onSortChange,
  totalCount,
  onClearAll,
  isFiltered,
}) {
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

  // Sort menus: brands with available products come first
  const sortedBrands = useMemo(() => {
    return [...menus].sort((a, b) => {
      const countA = brandCounts[a.id] || 0;
      const countB = brandCounts[b.id] || 0;
      if (countA > 0 && countB === 0) return -1;
      if (countA === 0 && countB > 0) return 1;
      return countB - countA;
    });
  }, [menus, brandCounts]);

  // Find active brand name
  const activeBrandObj = selectedBrand ? menus.find((m) => String(m.id) === String(selectedBrand)) : null;

  // Find price label
  const activePriceObj = selectedPriceRange ? priceOptions.find((p) => p.value === selectedPriceRange) : null;

  return (
    <div className="ac-catalog-header" id="danh-sach-san-pham">
      {/* Top Header Row with Title, Search & Result Count */}
      <div className="ac-catalog-top-row">
        <h2 className="ac-catalog-title">
          <span>Kho Máy Lạnh Chính Hãng</span>
          <span
            className="count-badge"
            style={{
              background: totalCount === 0 ? '#fee2e2' : undefined,
              color: totalCount === 0 ? '#ef4444' : undefined,
            }}
          >
            {totalCount} sản phẩm sẵn có
          </span>
        </h2>

        <div className="ac-catalog-search-wrap">
          <i className="fa fa-search"></i>
          <input
            type="text"
            className="ac-catalog-search-input"
            placeholder="Tìm theo model, tên máy lạnh (vd: FTKB25, Inverter...)"
            value={searchTerm}
            onChange={(e) => onSearchChange(e.target.value)}
          />
        </div>
      </div>

      {/* Active Filter Tags (Shows user exactly what is currently being filtered) */}
      {isFiltered && (
        <div className="ac-active-tags-bar">
          <span className="ac-active-tags-label">
            <i className="fa fa-filter"></i> Đang lọc:
          </span>

          {activeBrandObj && (
            <span className="ac-active-tag">
              Hãng: {formatBrandName(activeBrandObj.name)}
              <button
                type="button"
                onClick={() => onSelectBrand(null)}
                title="Bỏ lọc hãng này"
              >
                ✕
              </button>
            </span>
          )}

          {selectedHP && (
            <span className="ac-active-tag">
              Công suất: {selectedHP}
              <button
                type="button"
                onClick={() => onSelectHP('')}
                title="Bỏ lọc công suất"
              >
                ✕
              </button>
            </span>
          )}

          {activePriceObj && (
            <span className="ac-active-tag">
              Giá: {activePriceObj.label}
              <button
                type="button"
                onClick={() => onSelectPriceRange('')}
                title="Bỏ lọc mức giá"
              >
                ✕
              </button>
            </span>
          )}

          {onlyInverter && (
            <span className="ac-active-tag">
              Inverter Tiết Kiệm Điện
              <button
                type="button"
                onClick={onToggleInverter}
                title="Bỏ lọc Inverter"
              >
                ✕
              </button>
            </span>
          )}

          {onlyGasR32 && (
            <span className="ac-active-tag">
              Gas R32
              <button
                type="button"
                onClick={onToggleGasR32}
                title="Bỏ lọc Gas R32"
              >
                ✕
              </button>
            </span>
          )}

          {searchTerm.trim() && (
            <span className="ac-active-tag">
              Từ khóa: "{searchTerm}"
              <button
                type="button"
                onClick={() => onSearchChange('')}
                title="Xóa từ khóa"
              >
                ✕
              </button>
            </span>
          )}

          <button
            type="button"
            className="ac-clear-btn"
            style={{ marginLeft: 'auto' }}
            onClick={onClearAll}
          >
            <i className="fa fa-refresh"></i> Đặt lại toàn bộ
          </button>
        </div>
      )}

      {/* Filter 1: Hãng sản xuất / Thương hiệu (Danh mục) */}
      <div className="ac-filter-group">
        <div className="ac-filter-label">
          <i className="fa fa-th-large" style={{ color: '#0284c7' }}></i>
          <span>Thương hiệu:</span>
        </div>
        <div className="ac-filter-chips">
          <button
            type="button"
            className={`ac-chip ${!selectedBrand ? 'active' : ''}`}
            onClick={() => onSelectBrand(null)}
          >
            <span>Tất cả hãng</span>
          </button>
          {sortedBrands.map((brand) => {
            const isSelected = String(selectedBrand) === String(brand.id);
            const count = brandCounts[brand.id] || 0;
            return (
              <button
                key={brand.id}
                type="button"
                className={`ac-chip ${isSelected ? 'active' : ''}`}
                onClick={() => onSelectBrand(isSelected ? null : brand.id)}
              >
                <span>{formatBrandName(brand.name)}</span>
                <span className="ac-chip-sub" style={{ opacity: count === 0 ? 0.6 : 1 }}>
                  ({count})
                </span>
              </button>
            );
          })}
        </div>
      </div>

      {/* Filter 2: HP / Capacity */}
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
                onClick={() => onSelectHP(opt.value)}
              >
                <span>{opt.label}</span>
                {opt.sub && <span className="ac-chip-sub">({opt.sub})</span>}
              </button>
            );
          })}
        </div>
      </div>

      {/* Filter 3: Price Ranges */}
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
                onClick={() => onSelectPriceRange(opt.value)}
              >
                {opt.label}
              </button>
            );
          })}
        </div>
      </div>

      {/* Filter 4: Features & Sorting */}
      <div className="ac-catalog-sort-row">
        <div style={{ display: 'flex', alignItems: 'center', gap: 10, flexWrap: 'wrap' }}>
          <button
            type="button"
            className={`ac-chip ${onlyInverter ? 'active' : ''}`}
            onClick={onToggleInverter}
          >
            <i className="fa fa-leaf" style={{ color: onlyInverter ? '#fff' : '#16a34a' }}></i>
            <span>Inverter Tiết Kiệm Điện</span>
          </button>

          <button
            type="button"
            className={`ac-chip ${onlyGasR32 ? 'active' : ''}`}
            onClick={onToggleGasR32}
          >
            <i className="fa fa-tint" style={{ color: onlyGasR32 ? '#fff' : '#0284c7' }}></i>
            <span>Gas R32 Mới Nhất</span>
          </button>
        </div>

        <div style={{ display: 'flex', alignItems: 'center', gap: 14 }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: 6 }}>
            <span style={{ fontSize: 13, color: '#64748b' }}>Sắp xếp:</span>
            <select
              className="ac-sort-select"
              value={sortBy}
              onChange={(e) => onSortChange(e.target.value)}
            >
              <option value="newest">Mới nhất tại kho</option>
              <option value="price-asc">Giá: Thấp đến Cao</option>
              <option value="price-desc">Giá: Cao đến Thấp</option>
              <option value="views">Xem nhiều nhất</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  );
}
