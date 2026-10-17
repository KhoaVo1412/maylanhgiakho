import React, { useMemo } from 'react';

export default function BrandCatalog({ menus = [], selectedBrand, onSelectBrand, brandCounts = {} }) {
  // Sort brands so ones with products come first
  const brands = useMemo(() => {
    return menus
      .filter((m) => {
        const name = (m.name || '').toLowerCase();
        return !name.includes('nội địa');
      })
      .sort((a, b) => {
        const countA = brandCounts[a.id] || 0;
        const countB = brandCounts[b.id] || 0;
        if (countA > 0 && countB === 0) return -1;
        if (countA === 0 && countB > 0) return 1;
        return countB - countA;
      });
  }, [menus, brandCounts]);

  return (
    <section className="ac-brands-bar" aria-label="Thương hiệu máy lạnh hàng đầu">
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: 14 }}>
        <h3 style={{ fontSize: 18, fontWeight: 800, margin: 0, color: '#0f172a' }}>
          <i className="fa fa-th-large" style={{ color: '#0284c7', marginRight: 8 }}></i>
          Thương Hiệu Máy Lạnh Chính Hãng Tại Kho
        </h3>
        {selectedBrand && (
          <button
            type="button"
            className="ac-clear-btn"
            onClick={() => onSelectBrand(null)}
          >
            <i className="fa fa-times-circle"></i> Xem tất cả thương hiệu
          </button>
        )}
      </div>

      <div className="ac-brands-grid">
        {brands.map((brand) => {
          const isSelected = String(selectedBrand) === String(brand.id);
          const count = brandCounts[brand.id] || 0;
          return (
            <a
              key={brand.id}
              href={`/danh-muc/${brand.slug}`}
              className={`ac-brand-card ${isSelected ? 'active' : ''}`}
              title={`Xem toàn bộ máy lạnh ${brand.name}`}
              style={{ textDecoration: 'none' }}
            >
              {brand.thumb ? (
                <img src={brand.thumb} alt={`Máy lạnh ${brand.name}`} />
              ) : (
                <span style={{ fontWeight: 700, fontSize: 13, color: '#334155' }}>
                  {brand.name}
                </span>
              )}
              <span className={`ac-brand-count-badge ${count === 0 ? 'empty' : ''}`}>
                {count > 0 ? `${count} máy` : 'Tạm hết'}
              </span>
            </a>
          );
        })}
      </div>
    </section>
  );
}
