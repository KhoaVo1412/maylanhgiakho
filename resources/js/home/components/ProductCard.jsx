import React from 'react';
import { formatVND, calculateDiscount, extractHP, getRecommendedArea, isInverter, getGasType } from '../utils';

export default function ProductCard({ product, onQuickView }) {
  const hp = extractHP(product);
  const area = getRecommendedArea(hp);
  const inverter = isInverter(product);
  const gas = getGasType(product);

  const price = Number(product.price) || 0;
  const priceSale = Number(product.price_sale) || 0;
  const effectivePrice = priceSale > 0 ? priceSale : price;
  const discountPercent = calculateDiscount(price, priceSale);
  const savedAmount = price > priceSale && priceSale > 0 ? price - priceSale : 0;

  const detailUrl = `/san-pham/${product.slug || product.id}`;

  return (
    <div className="ac-product-card" itemScope itemType="http://schema.org/Product">
      {/* Badges */}
      <div className="ac-card-badge-wrap">
        {discountPercent > 0 && (
          <span className="ac-badge-discount">-{discountPercent}% GIÁ KHO</span>
        )}
        {inverter && (
          <span className="ac-badge-inverter">
            <i className="fa fa-leaf" style={{ marginRight: 3 }}></i> Inverter
          </span>
        )}
      </div>

      {/* Image Wrap */}
      <div className="ac-card-image-wrap">
        <a href={detailUrl} aria-label={product.name}>
          <img
            src={product.thumb || '/template/images/product-placeholder.jpg'}
            alt={product.name}
            itemProp="image"
            loading="lazy"
          />
        </a>

        {/* Quick View Button */}
        <button
          type="button"
          className="ac-card-quickview-btn"
          title="Xem nhanh thông số kỹ thuật"
          onClick={() => onQuickView(product)}
        >
          <i className="fa fa-eye"></i>
        </button>
      </div>

      {/* Body Details */}
      <div className="ac-card-body">
        {/* Specs Pills */}
        <div className="ac-card-specs-tags">
          <span className="ac-spec-pill hp-pill">
            <i className="fa fa-bolt"></i> {hp}
          </span>
          <span className="ac-spec-pill">
            <i className="fa fa-arrows-alt"></i> {area}
          </span>
          {gas && (
            <span className="ac-spec-pill gas-pill">
              <i className="fa fa-tint"></i> {gas}
            </span>
          )}
        </div>

        {/* Title */}
        <a href={detailUrl} className="ac-card-title" title={product.name} itemProp="url">
          <span itemProp="name">{product.name}</span>
        </a>

        {/* Rating */}
        <div className="ac-card-rating">
          <i className="fa fa-star"></i>
          <i className="fa fa-star"></i>
          <i className="fa fa-star"></i>
          <i className="fa fa-star"></i>
          <i className="fa fa-star"></i>
          <span>(5.0 • Đã bán {product.SL ? product.SL + 12 : 38}+)</span>
        </div>

        {/* Pricing Box */}
        <div className="ac-card-price-box" itemProp="offers" itemScope itemType="http://schema.org/Offer">
          {price > 0 && priceSale > 0 && price > priceSale && (
            <div className="ac-price-original">{formatVND(price)}</div>
          )}

          <div className="ac-price-sale" itemProp="price" content={effectivePrice}>
            {formatVND(effectivePrice)}
          </div>
          <meta itemProp="priceCurrency" content="VND" />

          {savedAmount > 0 && (
            <div className="ac-price-save">
              Tiết kiệm: {formatVND(savedAmount)}
            </div>
          )}
        </div>

        {/* Action Buttons */}
        <div className="ac-card-actions">
          <a href={detailUrl} className="ac-btn-detail">
            <span>Xem Chi Tiết</span>
            <i className="fa fa-arrow-right"></i>
          </a>
          <a
            href="https://zalo.me/0902800999"
            target="_blank"
            rel="noopener noreferrer"
            className="ac-btn-call"
            title="Tư vấn Zalo / Báo giá sỉ ngay"
          >
            <i className="fa fa-comments"></i>
          </a>
        </div>
      </div>
    </div>
  );
}
