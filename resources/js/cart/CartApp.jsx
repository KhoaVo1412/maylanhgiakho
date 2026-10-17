import React, { useState } from 'react';

export default function CartApp({ initialData = {} }) {
  const initialItems = initialData.items || [];
  const initialCoupon = initialData.coupon || null;
  const user = initialData.user || null;
  const provinces = initialData.provinces || [];
  const csrfToken = initialData.csrf_token || '';
  const flashSuccess = initialData.flash_success || null;
  const flashError = initialData.flash_error || null;

  const [items, setItems] = useState(initialItems);
  const [couponCode, setCouponCode] = useState('');
  const [paymentMethod, setPaymentMethod] = useState('1'); // 1 = COD, 2 = Chuyển khoản / VNPay
  const [isUpdating, setIsUpdating] = useState(false);
  const [toastMessage, setToastMessage] = useState(flashSuccess || null);

  // Customer Form state
  const [formData, setFormData] = useState({
    name: user ? user.name : '',
    phone: user ? (user.phone || '') : '',
    email: user ? (user.email || '') : '',
    address: user ? (user.address || '') : '',
    province: '',
    content: '',
  });

  // Calculate pricing
  const subtotal = items.reduce((sum, item) => sum + (Number(item.price) || 0) * (Number(item.qty) || 1), 0);

  // Coupon calculation
  let discountAmount = 0;
  if (initialCoupon && Array.isArray(initialCoupon) && initialCoupon.length > 0) {
    const cp = initialCoupon[0];
    if (cp.tngg === 1) { // percentage
      discountAmount = Math.round((subtotal * Number(cp.sotiengg)) / 100);
    } else if (cp.tngg === 2) { // fixed VND
      discountAmount = Number(cp.sotiengg) || 0;
    }
  }

  const finalTotal = Math.max(0, subtotal - discountAmount);

  // Format currency
  const formatVND = (num) => {
    return Number(num || 0).toLocaleString('vi-VN') + ' đ';
  };

  // Resolve thumbnail image
  const resolveThumb = (thumb) => {
    if (!thumb) return '/template/images/icons/iconml.png';
    if (thumb.startsWith('http://') || thumb.startsWith('https://')) return thumb;
    if (thumb.startsWith('/')) return thumb;
    return `/${thumb}`;
  };

  // Handle local quantity change
  const handleQuantityChange = (rowId, newQty) => {
    if (newQty < 1) return;
    setItems((prev) =>
      prev.map((item) => (item.rowId === rowId ? { ...item, qty: newQty } : item))
    );
  };

  // Handle Delete Item
  const handleDeleteItem = (rowId) => {
    if (window.confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
      window.location.href = `/carts/delete/${rowId}`;
    }
  };

  return (
    <div className="ac-app ac-cart-page">
      {/* Toast Alert */}
      {toastMessage && (
        <div className="ac-floating-toast">
          <span className="ac-toast-icon">✅</span>
          <span className="ac-toast-text">{toastMessage}</span>
          <button
            type="button"
            className="ac-modal-close"
            style={{ position: 'static', color: '#fff', fontSize: '14px', marginLeft: '12px' }}
            onClick={() => setToastMessage(null)}
          >
            ✕
          </button>
        </div>
      )}

      {flashError && (
        <div className="ac-container" style={{ marginTop: '16px' }}>
          <div className="ac-comment-alert error">
            ⚠️ {flashError}
          </div>
        </div>
      )}

      {/* Breadcrumb */}
      <div className="ac-breadcrumb-wrap">
        <div className="ac-container">
          <ul className="ac-breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li>/</li>
            <li className="active">Giỏ hàng của bạn</li>
          </ul>
        </div>
      </div>

      <div className="ac-container">
        {/* Header Title */}
        <div className="ac-cart-header-title-bar">
          <h1 className="ac-cart-page-title">
            <span>🛒</span> Giỏ Hàng Của Bạn {items.length > 0 && <span className="ac-cart-item-count">({items.length} sản phẩm)</span>}
          </h1>
          <a href="/" className="ac-continue-shopping-link">
            ← Tiếp tục mua sắm
          </a>
        </div>

        {/* Condition: Empty Cart vs Active Cart */}
        {items.length === 0 ? (
          <div className="ac-empty-cart-card">
            <div className="ac-empty-cart-icon">🛒</div>
            <h2>Giỏ hàng của bạn đang trống</h2>
            <p>
              Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy tham khảo các dòng máy lạnh chính hãng giá sỉ trực tiếp tại kho của chúng tôi!
            </p>
            <a href="/" className="ac-btn-empty-shop">
              ⚡ Khám Phá Máy Lạnh Giá Sỉ Ngay
            </a>
          </div>
        ) : (
          <div className="ac-cart-main-layout">
            {/* Left: Product Items Table */}
            <div className="ac-cart-items-col">
              <div className="ac-cart-table-card">
                <form action="/update-cart-quantity" method="POST" id="update-cart-form">
                  <input type="hidden" name="_token" value={csrfToken} />

                  <table className="ac-cart-table">
                    <thead>
                      <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th style={{ textAlign: 'center' }}>Số lượng</th>
                        <th>Thành tiền</th>
                        <th style={{ textAlign: 'center' }}>Xóa</th>
                      </tr>
                    </thead>
                    <tbody>
                      {items.map((item) => {
                        const itemPrice = Number(item.price) || 0;
                        const itemQty = Number(item.qty) || 1;
                        const itemTotal = itemPrice * itemQty;

                        return (
                          <tr key={item.rowId} className="ac-cart-row">
                            <td className="ac-col-product">
                              <div className="ac-cart-product-info">
                                <a href={`/san-pham/${item.slug || item.id}`} className="ac-cart-thumb-wrap">
                                  <img src={resolveThumb(item.thumb)} alt={item.name} />
                                </a>
                                <div className="ac-cart-name-wrap">
                                  <a href={`/san-pham/${item.slug || item.id}`} className="ac-cart-product-name">
                                    {item.name}
                                  </a>
                                  <span className="ac-cart-genuine-badge">Chính hãng 100%</span>
                                </div>
                              </div>
                            </td>

                            <td className="ac-col-price">
                              <span className="ac-cart-unit-price">{formatVND(itemPrice)}</span>
                            </td>

                            <td className="ac-col-qty" style={{ textAlign: 'center' }}>
                              <input type="hidden" name="rowId_cart[]" value={item.rowId} />
                              <div className="ac-qty-selector">
                                <button
                                  type="button"
                                  className="ac-qty-btn"
                                  onClick={() => handleQuantityChange(item.rowId, itemQty - 1)}
                                  disabled={itemQty <= 1}
                                >
                                  −
                                </button>
                                <input
                                  type="number"
                                  className="ac-qty-input-field"
                                  name={`num_product[${item.rowId}]`}
                                  value={itemQty}
                                  min="1"
                                  onChange={(e) =>
                                    handleQuantityChange(item.rowId, Math.max(1, parseInt(e.target.value) || 1))
                                  }
                                />
                                <button
                                  type="button"
                                  className="ac-qty-btn"
                                  onClick={() => handleQuantityChange(item.rowId, itemQty + 1)}
                                >
                                  +
                                </button>
                              </div>
                            </td>

                            <td className="ac-col-total">
                              <span className="ac-cart-line-total">{formatVND(itemTotal)}</span>
                            </td>

                            <td className="ac-col-action" style={{ textAlign: 'center' }}>
                              <button
                                type="button"
                                className="ac-cart-delete-btn"
                                onClick={() => handleDeleteItem(item.rowId)}
                                title="Xóa khỏi giỏ hàng"
                              >
                                🗑️
                              </button>
                            </td>
                          </tr>
                        );
                      })}
                    </tbody>
                  </table>

                  {/* Cart Action Buttons */}
                  <div className="ac-cart-table-footer">
                    <button
                      type="submit"
                      className="ac-btn-update-cart"
                      disabled={isUpdating}
                    >
                      🔄 Cập Nhật Số Lượng
                    </button>
                  </div>
                </form>

                {/* Coupon Box */}
                <form action="/check-coupon" method="POST" className="ac-cart-coupon-wrap">
                  <input type="hidden" name="_token" value={csrfToken} />
                  <div className="ac-coupon-input-group">
                    <span className="ac-coupon-icon">🏷️</span>
                    <input
                      type="text"
                      name="coupon"
                      placeholder="Nhập mã ưu đãi / giảm giá..."
                      value={couponCode}
                      onChange={(e) => setCouponCode(e.target.value)}
                    />
                    <button type="submit" name="check-coupon" className="ac-btn-apply-coupon">
                      Áp Dụng Mã
                    </button>
                  </div>
                  {initialCoupon && (
                    <div className="ac-coupon-applied-note">
                      ✓ Đã áp dụng mã giảm giá: <strong>{initialCoupon[0]?.magg}</strong>
                    </div>
                  )}
                </form>
              </div>

              {/* 4 Golden Commitments */}
              <div className="ac-cart-guarantees-card">
                <div className="ac-cart-guarantee-item">
                  <span className="ac-cg-icon">🚚</span>
                  <div>
                    <strong>Giao Hàng Miễn Phí</strong>
                    <small>Giao siêu tốc trong ngày khu vực TP.HCM</small>
                  </div>
                </div>
                <div className="ac-cart-guarantee-item">
                  <span className="ac-cg-icon">🛡️</span>
                  <div>
                    <strong>Bảo Hành Tận Nhà</strong>
                    <small>Kích hoạt bảo hành điện tử chính hãng 24 tháng</small>
                  </div>
                </div>
                <div className="ac-cart-guarantee-item">
                  <span className="ac-cg-icon">💵</span>
                  <div>
                    <strong>Kiểm Tra Mới Trả Tiền</strong>
                    <small>Nghiệm thu lắp đặt hài lòng mới thanh toán</small>
                  </div>
                </div>
              </div>
            </div>

            {/* Right: Order Summary & Checkout Customer Info Form */}
            <div className="ac-cart-checkout-col">
              <div className="ac-checkout-card">
                <h3 className="ac-checkout-card-title">Thông Tin Đặt Hàng & Thanh Toán</h3>

                {/* Pricing Summary */}
                <div className="ac-order-summary-box">
                  <div className="ac-summary-row">
                    <span>Tạm tính tiền máy:</span>
                    <strong>{formatVND(subtotal)}</strong>
                  </div>
                  {discountAmount > 0 && (
                    <div className="ac-summary-row discount">
                      <span>Mã giảm giá:</span>
                      <strong>-{formatVND(discountAmount)}</strong>
                    </div>
                  )}
                  <div className="ac-summary-row">
                    <span>Vận chuyển:</span>
                    <strong style={{ color: '#059669' }}>Miễn phí</strong>
                  </div>
                  <div className="ac-summary-divider"></div>
                  <div className="ac-summary-row total">
                    <span>Tổng thanh toán:</span>
                    <strong className="ac-cart-final-price">{formatVND(finalTotal)}</strong>
                  </div>
                  <small className="ac-vat-text">✓ Giá đã bao gồm thuế VAT</small>
                </div>

                {/* Checkout Submission Form */}
                <form action="/carts" method="POST" className="ac-checkout-form">
                  <input type="hidden" name="_token" value={csrfToken} />
                  <input type="hidden" name="tongtien" value={subtotal} />
                  <input type="hidden" name="tiengg" value={discountAmount} />
                  <input type="hidden" name="tientra" value={finalTotal} />
                  <input type="hidden" name="dstt" value="1" />

                  <div className="ac-form-section-title">
                    <span>👤</span> Thông Tin Người Nhận
                  </div>

                  <div className="ac-form-group">
                    <label>Họ và tên người nhận <span className="req">*</span></label>
                    <input
                      type="text"
                      name="name"
                      placeholder="Ví dụ: Nguyễn Văn A"
                      value={formData.name}
                      onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                      required
                    />
                  </div>

                  <div className="ac-form-group">
                    <label>Số điện thoại liên hệ <span className="req">*</span></label>
                    <input
                      type="tel"
                      name="phone"
                      placeholder="Ví dụ: 0912345678"
                      pattern="(\+84|0)\d{9,10}"
                      value={formData.phone}
                      onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                      required
                    />
                  </div>

                  <div className="ac-form-group">
                    <label>Địa chỉ nhận máy <span className="req">*</span></label>
                    <input
                      type="text"
                      name="address"
                      placeholder="Số nhà, tên đường, phường/xã, quận/huyện..."
                      value={formData.address}
                      onChange={(e) => setFormData({ ...formData, address: e.target.value })}
                      required
                    />
                  </div>

                  <div className="ac-form-group">
                    <label>Email nhận hóa đơn & bảo hành</label>
                    <input
                      type="email"
                      name="email"
                      placeholder="email@example.com"
                      value={formData.email}
                      onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                    />
                  </div>

                  {provinces && provinces.length > 0 && !user && (
                    <div className="ac-form-group">
                      <label>Tỉnh / Thành Phố</label>
                      <select
                        name="city"
                        value={formData.province}
                        onChange={(e) => setFormData({ ...formData, province: e.target.value })}
                      >
                        <option value="">Chọn Tỉnh / Thành Phố...</option>
                        {provinces.map((p) => (
                          <option key={p.id} value={p.name || p.id}>
                            {p.name}
                          </option>
                        ))}
                      </select>
                    </div>
                  )}

                  <div className="ac-form-group">
                    <label>Ghi chú đơn hàng (Thời gian lắp đặt, yêu cầu khác)</label>
                    <textarea
                      rows="3"
                      name="content"
                      placeholder="Ví dụ: Cần lắp gấp sáng mai, nhà lầu 2 cần thang dây..."
                      value={formData.content}
                      onChange={(e) => setFormData({ ...formData, content: e.target.value })}
                    ></textarea>
                  </div>

                  {/* Payment Method Radio Selection */}
                  <div className="ac-payment-methods-box">
                    <label className="ac-form-section-title">
                      <span>💳</span> Phương Thức Thanh Toán
                    </label>

                    <label className={`ac-payment-radio ${paymentMethod === '1' ? 'active' : ''}`}>
                      <input
                        type="radio"
                        name="pttt"
                        value="1"
                        checked={paymentMethod === '1'}
                        onChange={() => setPaymentMethod('1')}
                      />
                      <div className="ac-pay-details">
                        <strong>Thanh toán tiền mặt khi nhận hàng (COD)</strong>
                        <small>Kiểm tra máy móc, nguyên đai nguyên kiện rồi thanh toán</small>
                      </div>
                    </label>

                    <label className={`ac-payment-radio ${paymentMethod === '2' ? 'active' : ''}`}>
                      <input
                        type="radio"
                        name="pttt"
                        value="2"
                        checked={paymentMethod === '2'}
                        onChange={() => setPaymentMethod('2')}
                      />
                      <div className="ac-pay-details">
                        <strong>Chuyển khoản ngân hàng / VNPay QR</strong>
                        <small>Nhân viên tổng đài sẽ liên hệ hướng dẫn quét mã xác nhận</small>
                      </div>
                    </label>
                  </div>

                  {/* Submit Order Button */}
                  <button type="submit" className="ac-btn-place-order">
                    <span className="ac-btn-icon">⚡</span>
                    <div>
                      <strong>ĐẶT HÀNG NGAY (GIAO TẬN NƠI)</strong>
                      <small>Cam kết giá sỉ tại kho - Bảo hành chính hãng</small>
                    </div>
                  </button>
                </form>

                {/* Direct Consultation Hotline */}
                <div className="ac-cart-hotline-box">
                  <span>Cần tư vấn báo giá ngay? Gọi tổng đài:</span>
                  <a href="tel:0583593999" className="ac-cart-hotline-link">
                    📞 0583 593 999 (24/7)
                  </a>
                </div>
              </div>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
