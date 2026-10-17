import React, { useState } from 'react';

export default function ProductDetailApp({ initialData = {} }) {
  const product = initialData.productt || {};
  const variants = initialData.variants || [];
  const relatedProducts = initialData.related || [];
  const initialComments = initialData.comments || [];
  const csrfToken = initialData.csrf_token || '';

  // Gallery state
  const images = [
    product.thumb,
    product.thumb_dt1,
    product.thumb_dt2,
  ].filter(Boolean);

  const [activeImage, setActiveImage] = useState(images[0] || '/template/images/icons/iconml.png');
  const [lightboxOpen, setLightboxOpen] = useState(false);

  // Purchasing state
  const [quantity, setQuantity] = useState(1);
  const [toastMessage, setToastMessage] = useState(null);
  const [isAddingCart, setIsAddingCart] = useState(false);

  // Tabs state
  const [activeTab, setActiveTab] = useState('description');
  const [isExpanded, setIsExpanded] = useState(false);

  // Comments state
  const [comments, setComments] = useState(initialComments);
  const [commentName, setCommentName] = useState('');
  const [commentContent, setCommentContent] = useState('');
  const [commentRating, setCommentRating] = useState(5);
  const [commentSubmitting, setCommentSubmitting] = useState(false);
  const [commentAlert, setCommentAlert] = useState(null);

  // Format price helper
  const formatVND = (amount) => {
    if (!amount && amount !== 0) return 'Liên hệ';
    return Number(amount).toLocaleString('vi-VN') + ' đ';
  };

  // Image resolver
  const resolveImage = (img) => {
    if (!img) return '/template/images/icons/iconml.png';
    if (img.startsWith('http://') || img.startsWith('https://')) return img;
    if (img.startsWith('/')) return img;
    return `/${img}`;
  };

  // Pricing calculations
  const priceRegular = Number(product.price) || 0;
  const priceSale = Number(product.price_sale) || priceRegular;
  const hasDiscount = priceRegular > priceSale && priceSale > 0;
  const discountPercent = hasDiscount
    ? Math.round(((priceRegular - priceSale) / priceRegular) * 100)
    : 0;
  const saveAmount = hasDiscount ? priceRegular - priceSale : 0;

  // Handle Add to Cart
  const handleAddToCart = async (e, redirect = false) => {
    if (e) e.preventDefault();
    setIsAddingCart(true);

    try {
      const formData = new FormData();
      formData.append('_token', csrfToken);
      formData.append('product_id', product.id);
      formData.append('num_product', quantity);

      const response = await fetch('/add-cart', {
        method: 'POST',
        body: formData,
      });

      if (redirect || response.redirected) {
        window.location.href = '/carts';
        return;
      }

      setToastMessage('Đã thêm sản phẩm vào giỏ hàng thành công!');
      setTimeout(() => setToastMessage(null), 3500);

      // Trigger cart count update if element exists
      const cartNoti = document.querySelector('.icon-header-noti');
      if (cartNoti) {
        const curCount = parseInt(cartNoti.getAttribute('data-notify') || '0', 10);
        cartNoti.setAttribute('data-notify', curCount + quantity);
      }
    } catch {
      // Fallback: standard form submit
      const form = document.getElementById('native-cart-form');
      if (form) form.submit();
    } finally {
      setIsAddingCart(false);
    }
  };

  // Handle Comment Submit
  const handleSendComment = async (e) => {
    e.preventDefault();
    if (!commentName.trim() || !commentContent.trim()) {
      setCommentAlert({ type: 'error', text: 'Vui lòng nhập họ tên và nội dung nhận xét!' });
      return;
    }

    setCommentSubmitting(true);
    try {
      const formData = new FormData();
      formData.append('_token', csrfToken);
      formData.append('product_id', product.id);
      formData.append('comment_name', commentName);
      formData.append('comment_ct', commentContent);

      await fetch('/send-comment', {
        method: 'POST',
        body: formData,
      });

      const newComment = {
        id: Date.now(),
        comment_name: commentName,
        comment_ct: commentContent,
        comment_time: new Date().toLocaleString('vi-VN'),
        created_at: new Date().toISOString(),
      };

      setComments([newComment, ...comments]);
      setCommentName('');
      setCommentContent('');
      setCommentAlert({ type: 'success', text: 'Cảm ơn bạn đã gửi đánh giá! Bình luận của bạn đã được ghi nhận.' });
      setTimeout(() => setCommentAlert(null), 4000);
    } catch {
      setCommentAlert({ type: 'error', text: 'Không thể gửi bình luận, vui lòng thử lại sau.' });
    } finally {
      setCommentSubmitting(false);
    }
  };

  return (
    <div className="ac-app ac-product-detail-page">
      {/* Toast Notification */}
      {toastMessage && (
        <div className="ac-floating-toast">
          <span className="ac-toast-icon">✅</span>
          <span className="ac-toast-text">{toastMessage}</span>
          <a href="/carts" className="ac-toast-btn">Xem giỏ hàng →</a>
        </div>
      )}

      {/* Breadcrumb Bar */}
      <div className="ac-breadcrumb-wrap">
        <div className="ac-container">
          <ul className="ac-breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li>/</li>
            {product.menu && (
              <>
                <li>
                  <a href={`/danh-muc/${product.menu.slug}`}>
                    Máy lạnh {product.menu.name}
                  </a>
                </li>
                <li>/</li>
              </>
            )}
            <li className="active">{product.name}</li>
          </ul>
        </div>
      </div>

      <div className="ac-container">
        {/* Main 2-Column Product Section */}
        <div className="ac-pd-main-grid">
          {/* Left Column: Gallery & Trust */}
          <div className="ac-pd-gallery-col">
            <div className="ac-pd-gallery-card">
              <div className="ac-pd-main-img-wrap" onClick={() => setLightboxOpen(true)}>
                <img
                  src={resolveImage(activeImage)}
                  alt={product.name}
                  className="ac-pd-main-img"
                />
                {/* Badges */}
                <div className="ac-pd-badges-stack">
                  {hasDiscount && (
                    <span className="ac-pd-badge-sale">GIẢM {discountPercent}%</span>
                  )}
                  <span className="ac-pd-badge-genuine">Chính hãng 100%</span>
                  {product.name && product.name.toLowerCase().includes('inverter') && (
                    <span className="ac-pd-badge-inverter">Inverter Tiết Kiệm</span>
                  )}
                </div>
                <button type="button" className="ac-pd-btn-zoom" title="Phóng to ảnh">
                  🔍 Phóng to
                </button>
              </div>

              {/* Thumbnails */}
              {images.length > 1 && (
                <div className="ac-pd-thumbs-strip">
                  {images.map((img, idx) => (
                    <button
                      key={idx}
                      type="button"
                      className={`ac-pd-thumb-btn ${activeImage === img ? 'active' : ''}`}
                      onClick={() => setActiveImage(img)}
                    >
                      <img src={resolveImage(img)} alt={`Thumbnail ${idx + 1}`} />
                    </button>
                  ))}
                </div>
              )}
            </div>

            {/* 6 Commitment Badges */}
            <div className="ac-pd-commitments-box">
              <h3 className="ac-commit-header-title">
                <span>🛡️</span> Cam Kết Vàng Của MayLanhGiaKho
              </h3>
              <div className="ac-commit-grid">
                <div className="ac-commit-item">
                  <div className="ac-commit-icon">💎</div>
                  <div>
                    <strong>Chính Hãng 100%</strong>
                    <small>Mới nguyên đai nguyên kiện, chứng từ đầy đủ</small>
                  </div>
                </div>
                <div className="ac-commit-item">
                  <div className="ac-commit-icon">🔄</div>
                  <div>
                    <strong>1 Đổi 1 Trong 30 Ngày</strong>
                    <small>Hỗ trợ đổi mới nếu có lỗi từ nhà sản xuất</small>
                  </div>
                </div>
                <div className="ac-commit-item">
                  <div className="ac-commit-icon">🛡️</div>
                  <div>
                    <strong>Bảo Hành Tận Nhà</strong>
                    <small>Kích hoạt bảo hành điện tử chính hãng</small>
                  </div>
                </div>
                <div className="ac-commit-item">
                  <div className="ac-commit-icon">🚚</div>
                  <div>
                    <strong>Giao Hàng Miễn Phí</strong>
                    <small>Giao siêu tốc trong ngày tại TP.HCM</small>
                  </div>
                </div>
                <div className="ac-commit-item">
                  <div className="ac-commit-icon">💵</div>
                  <div>
                    <strong>Kiểm Tra Mới Trả Tiền</strong>
                    <small>Thanh toán sau khi lắp đặt & nghiệm thu</small>
                  </div>
                </div>
                <div className="ac-commit-item">
                  <div className="ac-commit-icon">👨‍🔧</div>
                  <div>
                    <strong>Lắp Đặt Chuyên Nghiệp</strong>
                    <small>Ống đồng Thái Lan, hút chân không máy Inverter</small>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Right Column: Pricing, Specs & Buy Actions */}
          <div className="ac-pd-info-col">
            <div className="ac-pd-info-card">
              {/* Brand and Model tag */}
              <div className="ac-pd-top-meta">
                {product.menu && (
                  <a href={`/danh-muc/${product.menu.slug}`} className="ac-pd-brand-tag">
                    HÃNG: {product.menu.name.toUpperCase()}
                  </a>
                )}
                {product.model && (
                  <span className="ac-pd-model-tag">Model: {product.model}</span>
                )}
                <span className="ac-pd-status-pill">Còn hàng tại kho</span>
              </div>

              {/* Title */}
              <h1 className="ac-pd-title">{product.name}</h1>

              {/* Rating & Sold count */}
              <div className="ac-pd-rating-bar">
                <div className="ac-pd-stars">⭐⭐⭐⭐⭐</div>
                <span className="ac-pd-rating-text">4.9 / 5.0</span>
                <span className="ac-pd-divider">•</span>
                <span className="ac-pd-review-count">{comments.length} đánh giá</span>
                <span className="ac-pd-divider">•</span>
                <span className="ac-pd-sold-badge">Đã bán 80+ chiếc</span>
              </div>

              {/* Price Box */}
              <div className="ac-pd-price-box">
                <div className="ac-pd-price-main-wrap">
                  <span className="ac-pd-sale-price">{formatVND(priceSale)}</span>
                  {hasDiscount && (
                    <span className="ac-pd-original-price">{formatVND(priceRegular)}</span>
                  )}
                </div>
                {hasDiscount && (
                  <div className="ac-pd-save-badge">
                    <span>Tiết kiệm ngay: <strong>{formatVND(saveAmount)}</strong> ({discountPercent}%)</span>
                  </div>
                )}
                <div className="ac-pd-vat-note">
                  ✓ Giá đã bao gồm thuế VAT • Cam kết giá sỉ rẻ nhất thị trường
                </div>
              </div>

              {/* Horsepower / Variant Selector */}
              {variants && variants.length > 0 && (
                <div className="ac-pd-variants-section">
                  <div className="ac-pd-variants-label">
                    <span>Chọn công suất máy lạnh (HP):</span>
                    <small>Bấm vào công suất để xem máy tương ứng</small>
                  </div>
                  <div className="ac-pd-variants-list">
                    {variants.map((v) => {
                      const isCurrent = v.id === product.id || v.slug === product.slug;
                      return (
                        <a
                          key={v.id}
                          href={`/san-pham/${v.slug}`}
                          className={`ac-pd-variant-chip ${isCurrent ? 'active' : ''}`}
                        >
                          <div className="ac-variant-top">
                            <span className="ac-variant-hp">{v.maluc || v.name}</span>
                            {isCurrent && <span className="ac-variant-check">✓ Đang chọn</span>}
                          </div>
                          <span className="ac-variant-price">{formatVND(v.price_sale)}</span>
                        </a>
                      );
                    })}
                  </div>
                </div>
              )}

              {/* Key Specs Highlights */}
              <div className="ac-pd-quick-specs">
                <div className="ac-quick-spec-item">
                  <span className="ac-qs-icon">⚡</span>
                  <div>
                    <span className="ac-qs-label">Công nghệ Inverter</span>
                    <strong>{product.name && product.name.toLowerCase().includes('inverter') ? 'Có (Tiết kiệm điện)' : 'Tiêu chuẩn'}</strong>
                  </div>
                </div>
                <div className="ac-quick-spec-item">
                  <span className="ac-qs-icon">❄️</span>
                  <div>
                    <span className="ac-qs-label">Loại Gas làm lạnh</span>
                    <strong>{product.loaigas || 'Gas R32 thế hệ mới'}</strong>
                  </div>
                </div>
                <div className="ac-quick-spec-item">
                  <span className="ac-qs-icon">🌍</span>
                  <div>
                    <span className="ac-qs-label">Xuất xứ sản phẩm</span>
                    <strong>{product.xuatxu || 'Chính hãng'}</strong>
                  </div>
                </div>
                <div className="ac-quick-spec-item">
                  <span className="ac-qs-icon">🛡️</span>
                  <div>
                    <span className="ac-qs-label">Thời gian bảo hành</span>
                    <strong>{product.tgbh || '24 tháng chính hãng'}</strong>
                  </div>
                </div>
              </div>

              {/* Notice for Installation Pricing */}
              <div className="ac-pd-installation-alert">
                <span className="ac-alert-badge">VẬT TƯ & LẮP ĐẶT</span>
                <p>
                  Chi phí nhân công & vật tư ống đồng được nghiệm thu thực tế theo số mét công trình.
                  <a href="/banggia" target="_blank" rel="noopener noreferrer">
                    Xem bảng giá chi tiết tại đây →
                  </a>
                </p>
              </div>

              {/* Native form for fallback */}
              <form id="native-cart-form" action="/add-cart" method="POST" style={{ display: 'none' }}>
                <input type="hidden" name="_token" value={csrfToken} />
                <input type="hidden" name="product_id" value={product.id} />
                <input type="hidden" name="num_product" value={quantity} />
              </form>

              {/* Quantity and Actions */}
              <div className="ac-pd-buy-block">
                <div className="ac-pd-qty-wrapper">
                  <span className="ac-qty-label">Số lượng:</span>
                  <div className="ac-qty-selector">
                    <button
                      type="button"
                      className="ac-qty-btn"
                      onClick={() => setQuantity(Math.max(1, quantity - 1))}
                      disabled={quantity <= 1}
                    >
                      −
                    </button>
                    <span className="ac-qty-value">{quantity}</span>
                    <button
                      type="button"
                      className="ac-qty-btn"
                      onClick={() => setQuantity(quantity + 1)}
                    >
                      +
                    </button>
                  </div>
                </div>

                <div className="ac-pd-action-buttons">
                  <button
                    type="button"
                    className="ac-btn-add-cart"
                    onClick={(e) => handleAddToCart(e, false)}
                    disabled={isAddingCart}
                  >
                    <span className="ac-btn-icon">🛒</span>
                    <span>{isAddingCart ? 'Đang thêm...' : 'THÊM VÀO GIỎ HÀNG'}</span>
                  </button>

                  <button
                    type="button"
                    className="ac-btn-buy-now"
                    onClick={(e) => handleAddToCart(e, true)}
                    disabled={isAddingCart}
                  >
                    <span className="ac-btn-icon">⚡</span>
                    <div>
                      <strong>MUA NGAY (GIAO TẬN NƠI)</strong>
                      <small>Thanh toán khi nhận hàng & lắp đặt</small>
                    </div>
                  </button>
                </div>
              </div>

              {/* Hotline & Zalo Fast Contact */}
              <div className="ac-pd-fast-contacts">
                <a href="tel:0583593999" className="ac-fast-btn hotline">
                  <span>📞</span>
                  <div>
                    <small>Tư vấn chuyên sâu 24/7</small>
                    <strong>0583 593 999</strong>
                  </div>
                </a>
                <a
                  href={`https://zalo.me/0583593999?text=${encodeURIComponent(
                    `Tôi muốn được tư vấn giá máy lạnh: ${product.name} (Giá: ${formatVND(priceSale)})`
                  )}`}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="ac-fast-btn zalo"
                >
                  <span className="ac-zalo-mini">Zalo</span>
                  <div>
                    <small>Báo giá sỉ công trình</small>
                    <strong>Chat Zalo ngay</strong>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        {/* Product Details & Specifications Tabs */}
        <div className="ac-pd-tabs-section">
          <div className="ac-pd-tab-headers">
            <button
              type="button"
              className={`ac-pd-tab-btn ${activeTab === 'description' ? 'active' : ''}`}
              onClick={() => setActiveTab('description')}
            >
              📄 Đặc Điểm Nổi Bật
            </button>
            <button
              type="button"
              className={`ac-pd-tab-btn ${activeTab === 'specs' ? 'active' : ''}`}
              onClick={() => setActiveTab('specs')}
            >
              ⚙️ Thông Số Kỹ Thuật
            </button>
            <button
              type="button"
              className={`ac-pd-tab-btn ${activeTab === 'pricing' ? 'active' : ''}`}
              onClick={() => setActiveTab('pricing')}
            >
              📋 Chi Phí Lắp Đặt & Vật Tư
            </button>
            <button
              type="button"
              className={`ac-pd-tab-btn ${activeTab === 'reviews' ? 'active' : ''}`}
              onClick={() => setActiveTab('reviews')}
            >
              💬 Đánh Giá & Nhận Xét ({comments.length})
            </button>
          </div>

          <div className="ac-pd-tab-content-box">
            {/* Tab 1: Description */}
            {activeTab === 'description' && (
              <div className="ac-tab-pane">
                <div className={`ac-html-content ${isExpanded ? 'expanded' : 'collapsed'}`}>
                  {product.content ? (
                    <div dangerouslySetInnerHTML={{ __html: product.content }} />
                  ) : (
                    <p>{product.description || 'Thông tin chi tiết của sản phẩm đang được cập nhật...'}</p>
                  )}
                </div>

                <div className="ac-expand-toggle-wrap">
                  <button
                    type="button"
                    className="ac-btn-toggle-expand"
                    onClick={() => setIsExpanded(!isExpanded)}
                  >
                    {isExpanded ? '▲ Thu gọn nội dung' : '▼ Xem toàn bộ bài viết đánh giá'}
                  </button>
                </div>
              </div>
            )}

            {/* Tab 2: Specs */}
            {activeTab === 'specs' && (
              <div className="ac-tab-pane">
                <h3 className="ac-tab-pane-title">Thông Số Kỹ Thuật Chi Tiết</h3>
                <div className="ac-specs-table-wrapper">
                  <table className="ac-specs-table">
                    <tbody>
                      <tr>
                        <td className="ac-spec-label">Model sản phẩm</td>
                        <td className="ac-spec-val"><strong>{product.model || 'Đang cập nhật'}</strong></td>
                      </tr>
                      <tr>
                        <td className="ac-spec-label">Hãng sản xuất / Thương hiệu</td>
                        <td className="ac-spec-val">{product.menu ? product.menu.name : (product.nsx || 'Chính hãng')}</td>
                      </tr>
                      <tr>
                        <td className="ac-spec-label">Công suất làm lạnh (HP)</td>
                        <td className="ac-spec-val">{product.maluc || 'Theo tiêu chuẩn nhà sản xuất'}</td>
                      </tr>
                      <tr>
                        <td className="ac-spec-label">Màu sắc</td>
                        <td className="ac-spec-val">{product.mausac || 'Trắng trang nhã'}</td>
                      </tr>
                      <tr>
                        <td className="ac-spec-label">Nơi sản xuất (Xuất xứ)</td>
                        <td className="ac-spec-val">{product.xuatxu || 'Chính hãng'}</td>
                      </tr>
                      <tr>
                        <td className="ac-spec-label">Năm ra mắt</td>
                        <td className="ac-spec-val">{product.namramat || 'Mới nhất'}</td>
                      </tr>
                      <tr>
                        <td className="ac-spec-label">Loại Gas làm lạnh</td>
                        <td className="ac-spec-val">{product.loaigas || 'R32 (Thân thiện môi trường, lạnh sâu)'}</td>
                      </tr>
                      <tr>
                        <td className="ac-spec-label">Công nghệ kháng khuẩn / Khử mùi</td>
                        <td className="ac-spec-val">{product.khumui || 'Lọc bụi mịn, diệt khuẩn IAQ'}</td>
                      </tr>
                      <tr>
                        <td className="ac-spec-label">Thời gian bảo hành</td>
                        <td className="ac-spec-val"><strong style={{ color: '#059669' }}>{product.tgbh || '24 tháng'}</strong></td>
                      </tr>
                      <tr>
                        <td className="ac-spec-label">Địa điểm bảo hành</td>
                        <td className="ac-spec-val">{product.ddiembh || 'Bảo hành tận nhà toàn quốc'}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            )}

            {/* Tab 3: Installation & Pricing */}
            {activeTab === 'pricing' && (
              <div className="ac-tab-pane">
                <h3 className="ac-tab-pane-title">Bảng Giá Nhân Công & Vật Tư Lắp Đặt Tham Khảo</h3>
                <p className="ac-tab-pane-desc">
                  Áp dụng cho máy lạnh treo tường dân dụng tại khu vực TP.HCM. 
                  Chi phí nghiệm thu chính xác dựa trên số mét thực tế.
                </p>

                <div className="ac-specs-table-wrapper">
                  <table className="ac-specs-table">
                    <thead>
                      <tr>
                        <th>Hạng mục dịch vụ / Vật tư</th>
                        <th>Quy cách / Xuất xứ</th>
                        <th>ĐVT</th>
                        <th>Đơn giá (VNĐ)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Nhân công lắp đặt máy lạnh treo tường (1.0 - 1.5 HP)</td>
                        <td>Chuẩn hãng, hút chân không</td>
                        <td>Bộ</td>
                        <td><strong style={{ color: '#dc2626' }}>350.000 đ</strong></td>
                      </tr>
                      <tr>
                        <td>Nhân công lắp đặt máy lạnh treo tường (2.0 - 2.5 HP)</td>
                        <td>Chuẩn hãng, hút chân không</td>
                        <td>Bộ</td>
                        <td><strong style={{ color: '#dc2626' }}>500.000 - 700.000 đ</strong></td>
                      </tr>
                      <tr>
                        <td>Ống gas 6.4x9.5mm dày 0.71mm (cho máy 1.0 - 1.5 HP)</td>
                        <td>Thái Lan (Bảo ôn đôi)</td>
                        <td>Mét</td>
                        <td><strong style={{ color: '#dc2626' }}>150.000 đ</strong></td>
                      </tr>
                      <tr>
                        <td>Ống gas 6.4x12.7mm dày 0.71mm (cho máy 2.0 - 2.5 HP)</td>
                        <td>Thái Lan (Bảo ôn đôi)</td>
                        <td>Mét</td>
                        <td><strong style={{ color: '#dc2626' }}>190.000 đ</strong></td>
                      </tr>
                      <tr>
                        <td>Dây điện nguồn 2.0mm & Ống thoát nước mềm</td>
                        <td>Daphaco / Bình Minh</td>
                        <td>Mét</td>
                        <td>10.000 - 12.000 đ</td>
                      </tr>
                      <tr>
                        <td>CB điện an toàn + Hộp đựng 32A</td>
                        <td>MPE</td>
                        <td>Bộ</td>
                        <td>150.000 đ</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div style={{ marginTop: '20px', textAlign: 'center' }}>
                  <a href="/banggia" className="ac-btn-read-more" style={{ fontSize: '15px' }}>
                    Xem toàn bộ bảng giá vật tư & dịch vụ chi tiết →
                  </a>
                </div>
              </div>
            )}

            {/* Tab 4: Reviews & Comments */}
            {activeTab === 'reviews' && (
              <div className="ac-tab-pane">
                <div className="ac-reviews-container">
                  <div className="ac-reviews-list-col">
                    <h3 className="ac-tab-pane-title">Khách Hàng Nhận Xét ({comments.length})</h3>

                    {comments.length === 0 ? (
                      <div className="ac-no-comments">
                        <span style={{ fontSize: '30px' }}>💬</span>
                        <p>Chưa có nhận xét nào cho sản phẩm này. Hãy là người đầu tiên đánh giá!</p>
                      </div>
                    ) : (
                      <div className="ac-comments-feed">
                        {comments.map((cm, idx) => (
                          <div key={cm.id || idx} className="ac-comment-item">
                            <div className="ac-comment-avatar">
                              {cm.comment_name ? cm.comment_name.charAt(0).toUpperCase() : 'U'}
                            </div>
                            <div className="ac-comment-body">
                              <div className="ac-comment-header">
                                <strong className="ac-comment-user">{cm.comment_name}</strong>
                                <span className="ac-comment-stars">⭐⭐⭐⭐⭐</span>
                                <span className="ac-comment-date">{cm.comment_time || 'Gần đây'}</span>
                              </div>
                              <p className="ac-comment-text">{cm.comment_ct}</p>
                            </div>
                          </div>
                        ))}
                      </div>
                    )}
                  </div>

                  {/* Add Review Form */}
                  <div className="ac-reviews-form-col">
                    <div className="ac-review-box-card">
                      <h4>Gửi Đánh Giá Của Bạn</h4>
                      <p>Chia sẻ trải nghiệm thực tế để giúp những khách hàng khác dễ dàng lựa chọn.</p>

                      {commentAlert && (
                        <div className={`ac-comment-alert ${commentAlert.type}`}>
                          {commentAlert.text}
                        </div>
                      )}

                      <form onSubmit={handleSendComment} className="ac-comment-form">
                        <div className="ac-rating-stars-picker">
                          <label>Chọn đánh giá của bạn:</label>
                          <div className="ac-star-picker-btns">
                            {[5, 4, 3, 2, 1].map((s) => (
                              <button
                                key={s}
                                type="button"
                                className={`ac-star-btn ${commentRating === s ? 'active' : ''}`}
                                onClick={() => setCommentRating(s)}
                              >
                                {'★'.repeat(s)} ({s} sao)
                              </button>
                            ))}
                          </div>
                        </div>

                        <div className="ac-form-group">
                          <label>Họ và tên của bạn:</label>
                          <input
                            type="text"
                            placeholder="Ví dụ: Anh Tuấn, Chị Hoa..."
                            value={commentName}
                            onChange={(e) => setCommentName(e.target.value)}
                            required
                          />
                        </div>

                        <div className="ac-form-group">
                          <label>Nội dung nhận xét / Câu hỏi:</label>
                          <textarea
                            rows="4"
                            placeholder="Cảm nhận về độ êm, khả năng làm lạnh, chất lượng phục vụ của thợ..."
                            value={commentContent}
                            onChange={(e) => setCommentContent(e.target.value)}
                            required
                          ></textarea>
                        </div>

                        <button
                          type="submit"
                          className="ac-btn-submit-comment"
                          disabled={commentSubmitting}
                        >
                          {commentSubmitting ? 'Đang gửi đánh giá...' : 'GỬI ĐÁNH GIÁ NGAY'}
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            )}
          </div>
        </div>

        {/* Related Products Section */}
        {relatedProducts && relatedProducts.length > 0 && (
          <div className="ac-pd-related-section">
            <div className="ac-section-header">
              <h2 className="ac-section-title">
                <span className="ac-title-accent"></span> Sản Phẩm Cùng Thương Hiệu Được Ưa Chuộng
              </h2>
              <span className="ac-section-subtitle">
                Các dòng máy lạnh chính hãng cùng phân khúc chất lượng cao tại MayLanhGiaKho
              </span>
            </div>

            <div className="ac-related-grid">
              {relatedProducts.slice(0, 4).map((rel) => {
                const relPrice = Number(rel.price) || 0;
                const relSale = Number(rel.price_sale) || relPrice;
                const relDiscount = relPrice > relSale ? Math.round(((relPrice - relSale) / relPrice) * 100) : 0;

                return (
                  <div key={rel.id} className="ac-product-card">
                    {relDiscount > 0 && (
                      <span className="ac-badge ac-badge-sale">-{relDiscount}%</span>
                    )}
                    <a href={`/san-pham/${rel.slug}`} className="ac-card-image-wrap">
                      <img src={resolveImage(rel.thumb)} alt={rel.name} loading="lazy" />
                    </a>
                    <div className="ac-card-content">
                      <h3 className="ac-card-title">
                        <a href={`/san-pham/${rel.slug}`}>{rel.name}</a>
                      </h3>
                      <div className="ac-card-pricing">
                        <span className="ac-price-current">{formatVND(relSale)}</span>
                        {relDiscount > 0 && (
                          <span className="ac-price-original">{formatVND(relPrice)}</span>
                        )}
                      </div>
                      <div className="ac-card-actions">
                        <a href={`/san-pham/${rel.slug}`} className="ac-btn ac-btn-primary full-width">
                          Xem chi tiết
                        </a>
                      </div>
                    </div>
                  </div>
                );
              })}
            </div>
          </div>
        )}
      </div>

      {/* Lightbox Modal */}
      {lightboxOpen && (
        <div className="ac-modal-backdrop" onClick={() => setLightboxOpen(false)}>
          <div className="ac-lightbox-content" onClick={(e) => e.stopPropagation()}>
            <button
              type="button"
              className="ac-modal-close"
              onClick={() => setLightboxOpen(false)}
            >
              ✕
            </button>
            <img src={resolveImage(activeImage)} alt={product.name} />
          </div>
        </div>
      )}

      {/* Mobile Sticky Bottom Action Bar */}
      <div className="ac-mobile-bottom-bar">
        <a href="tel:0583593999" className="ac-mb-btn-call">
          <span>📞</span>
          <small>Gọi tư vấn</small>
        </a>
        <a
          href={`https://zalo.me/0583593999?text=${encodeURIComponent(
            `Tôi muốn mua máy: ${product.name} (${formatVND(priceSale)})`
          )}`}
          target="_blank"
          rel="noopener noreferrer"
          className="ac-mb-btn-zalo"
        >
          <span>💬</span>
          <small>Zalo</small>
        </a>
        <button
          type="button"
          className="ac-mb-btn-buy"
          onClick={(e) => handleAddToCart(e, true)}
        >
          <strong>MUA NGAY</strong>
          <small>{formatVND(priceSale)}</small>
        </button>
      </div>
    </div>
  );
}
