import React from 'react';
import { formatVND, calculateDiscount, extractHP, getRecommendedArea, isInverter, getGasType } from '../utils';

export default function QuickViewModal({ product, onClose }) {
  if (!product) return null;

  const hp = extractHP(product);
  const area = getRecommendedArea(hp);
  const inverter = isInverter(product);
  const gas = getGasType(product);

  const price = Number(product.price) || 0;
  const priceSale = Number(product.price_sale) || 0;
  const effectivePrice = priceSale > 0 ? priceSale : price;
  const discountPercent = calculateDiscount(price, priceSale);
  const detailUrl = `/san-pham/${product.slug || product.id}`;

  return (
    <div className="ac-modal-backdrop" onClick={onClose}>
      <div className="ac-modal-content" onClick={(e) => e.stopPropagation()}>
        <button type="button" className="ac-modal-close-btn" onClick={onClose}>
          <i className="fa fa-times"></i>
        </button>

        <div className="ac-qv-grid">
          {/* Image */}
          <div className="ac-qv-image-box">
            <img src={product.thumb || '/template/images/product-placeholder.jpg'} alt={product.name} />
          </div>

          {/* Details */}
          <div className="ac-qv-details">
            <span
              style={{
                fontSize: 12,
                fontWeight: 700,
                color: '#0284c7',
                textTransform: 'uppercase',
                letterSpacing: 0.5,
              }}
            >
              MÁY LẠNH CHÍNH HÃNG TẠI KHO
            </span>
            <h3>{product.name}</h3>

            {/* Price Box */}
            <div className="ac-qv-price-row">
              <span className="sale">{formatVND(effectivePrice)}</span>
              {price > effectivePrice && (
                <span className="original">{formatVND(price)}</span>
              )}
              {discountPercent > 0 && (
                <span className="ac-badge-discount">-{discountPercent}%</span>
              )}
            </div>

            {/* Specs Table */}
            <table className="ac-qv-specs-table">
              <tbody>
                <tr>
                  <td className="label">Công suất làm lạnh:</td>
                  <td className="value">{hp} ({area})</td>
                </tr>
                <tr>
                  <td className="label">Công nghệ tiết kiệm điện:</td>
                  <td className="value">{inverter ? 'Inverter Tiết kiệm điện' : 'Máy lạnh tiêu chuẩn'}</td>
                </tr>
                <tr>
                  <td className="label">Loại môi chất lạnh:</td>
                  <td className="value">{gas}</td>
                </tr>
                {product.model && (
                  <tr>
                    <td className="label">Model máy:</td>
                    <td className="value">{product.model}</td>
                  </tr>
                )}
                {product.xuatxu && (
                  <tr>
                    <td className="label">Xuất xứ:</td>
                    <td className="value">{product.xuatxu}</td>
                  </tr>
                )}
                <tr>
                  <td className="label">Bảo hành chính hãng:</td>
                  <td className="value">{product.tgbh || '24 Tháng tận nơi'}</td>
                </tr>
                <tr>
                  <td className="label">Tình trạng máy:</td>
                  <td className="value" style={{ color: '#16a34a' }}>
                    <i className="fa fa-check-circle"></i> Mới 100% nguyên đai nguyên kiện
                  </td>
                </tr>
              </tbody>
            </table>

            {/* CTA Buttons */}
            <div style={{ display: 'flex', gap: 10, marginTop: 20 }}>
              <a href={detailUrl} className="ac-slide-btn" style={{ flex: 1, textAlign: 'center' }}>
                <span>Xem Chi Tiết & Đặt Hàng</span>
                <i className="fa fa-arrow-right"></i>
              </a>

              <a
                href="https://zalo.me/0902800999"
                target="_blank"
                rel="noopener noreferrer"
                className="ac-slide-btn"
                style={{ background: '#10b981', color: '#fff' }}
              >
                <i className="fa fa-phone"></i>
                <span>Tư Vấn Zalo</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
