import React, { useState, useEffect, useRef } from 'react';

export default function NewsDetailApp({ initialData = {} }) {
  const tintuc = initialData.tintuc || {};
  const otherPosts = initialData.otherPosts || [];
  const featuredProducts = initialData.featuredProducts || [];

  // Reading progress state
  const [scrollProgress, setScrollProgress] = useState(0);

  // Font size multiplier: 0.95, 1, 1.15
  const [fontScale, setFontScale] = useState(1);

  // Toast notification
  const [toast, setToast] = useState(null);

  // Table of Contents
  const [toc, setToc] = useState([]);
  const [isTocOpen, setIsTocOpen] = useState(true);

  // Feedback state
  const [feedbackGiven, setFeedbackGiven] = useState(null);

  // Ref to the article content
  const contentRef = useRef(null);

  // Track scroll for progress bar
  useEffect(() => {
    const handleScroll = () => {
      const totalScroll = document.documentElement.scrollTop;
      const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      if (windowHeight > 0) {
        const scrolled = (totalScroll / windowHeight) * 100;
        setScrollProgress(Math.min(100, Math.max(0, scrolled)));
      }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  // Parse Table of Contents from rendered HTML
  useEffect(() => {
    if (!contentRef.current) return;

    const headings = contentRef.current.querySelectorAll('h2, h3');
    const items = [];

    headings.forEach((heading, index) => {
      let id = heading.getAttribute('id');
      if (!id) {
        id = `section-heading-${index + 1}`;
        heading.setAttribute('id', id);
      }
      items.push({
        id,
        text: heading.textContent.trim(),
        level: heading.tagName.toLowerCase(),
      });
    });

    setToc(items);
  }, [tintuc.detail_descriptions]);

  // Helpers
  const formatDate = (dateStr) => {
    if (!dateStr) return '';
    try {
      const d = new Date(dateStr);
      return d.toLocaleDateString('vi-VN', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
      });
    } catch {
      return dateStr;
    }
  };

  const resolveImage = (img) => {
    if (!img) return '/template/images/icons/iconml.png';
    if (img.startsWith('http://') || img.startsWith('https://')) return img;
    if (img.startsWith('/')) return img;
    return `/${img}`;
  };

  const formatVND = (amount) => {
    if (!amount || amount === 0) return 'Liên hệ';
    return Number(amount).toLocaleString('vi-VN') + ' đ';
  };

  // Calculate estimated reading time
  const readingTime = (() => {
    const text = (tintuc.detail_descriptions || '').replace(/<[^>]*>/g, ' ');
    const wordCount = text.trim().split(/\s+/).filter(Boolean).length;
    return Math.max(2, Math.ceil(wordCount / 200));
  })();

  // Copy link handler
  const handleCopyLink = () => {
    if (navigator.clipboard) {
      navigator.clipboard.writeText(window.location.href);
      setToast('Đã sao chép liên kết bài viết thành công!');
      setTimeout(() => setToast(null), 3000);
    }
  };

  // Share Facebook
  const handleShareFacebook = () => {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=500');
  };

  // Share Zalo
  const handleShareZalo = () => {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://sp.zalo.me/plugins/share?url=${url}`, '_blank', 'width=600,height=500');
  };

  // Print article
  const handlePrint = () => {
    window.print();
  };

  // Smooth scroll to TOC item
  const scrollToHeading = (id) => {
    const target = document.getElementById(id);
    if (target) {
      const topOffset = 90; // offset for sticky header
      const elementPosition = target.getBoundingClientRect().top;
      const offsetPosition = elementPosition + window.pageYOffset - topOffset;

      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth',
      });
    }
  };

  const categoryName = tintuc.danh_muc?.name || 'Cẩm Nang Máy Lạnh';

  return (
    <div className="ac-app ac-news-detail-page">
      {/* 1. Top Reading Progress Bar */}
      <div 
        className="ac-reading-progress" 
        style={{ width: `${scrollProgress}%` }} 
        aria-hidden="true"
      />

      {/* Floating Toast Notification */}
      {toast && (
        <div className="ac-nd-toast" role="status">
          <span className="ac-toast-icon">✓</span>
          <span>{toast}</span>
        </div>
      )}

      {/* 2. Breadcrumb Navigation */}
      <div className="ac-breadcrumb-wrap">
        <div className="ac-container">
          <ul className="ac-breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li>/</li>
            <li><a href="/tintuc">Tin tức & Cẩm nang</a></li>
            <li>/</li>
            <li className="active" title={tintuc.name}>
              {tintuc.name ? (tintuc.name.length > 55 ? tintuc.name.slice(0, 55) + '...' : tintuc.name) : 'Chi tiết bài viết'}
            </li>
          </ul>
        </div>
      </div>

      <div className="ac-container">
        {/* Main 2-Column Layout */}
        <div className="ac-nd-layout">
          {/* LEFT COLUMN: Main Post */}
          <main className="ac-nd-main-col" id="article-main">
            <article className="ac-nd-article-card">
              {/* Category Pill */}
              <div className="ac-nd-category-row">
                <span className="ac-nd-category-badge">
                  🏷️ {categoryName}
                </span>
                <span className="ac-nd-verified-pill">
                  ✓ Đã kiểm duyệt chuyên môn
                </span>
              </div>

              {/* Title */}
              <h1 className="ac-nd-title">
                {tintuc.name}
              </h1>

              {/* Meta Info Bar */}
              <div className="ac-nd-meta-bar">
                <div className="ac-nd-author-info">
                  <div className="ac-nd-author-avatar">
                    <span>❄️</span>
                  </div>
                  <div>
                    <span className="ac-nd-author-name">Chuyên Gia Điện Lạnh</span>
                    <span className="ac-nd-author-team">Ban Kỹ Thuật MayLanhGiaKho</span>
                  </div>
                </div>

                <div className="ac-nd-meta-stats">
                  <span className="ac-nd-stat-item">
                    📅 {formatDate(tintuc.created_at) || 'Cập nhật hôm nay'}
                  </span>
                  <span className="ac-nd-stat-dot">•</span>
                  <span className="ac-nd-stat-item">
                    ⏱️ ~{readingTime} phút đọc
                  </span>
                  <span className="ac-nd-stat-dot">•</span>
                  <span className="ac-nd-stat-item">
                    👁️ 2.4k lượt xem
                  </span>
                </div>
              </div>

              {/* Action Toolbar: Font Zoom, Share, Print */}
              <div className="ac-nd-toolbar">
                <div className="ac-nd-share-actions">
                  <span className="ac-nd-share-label">Chia sẻ:</span>
                  <button 
                    type="button" 
                    className="ac-nd-btn-share fb" 
                    onClick={handleShareFacebook}
                    title="Chia sẻ lên Facebook"
                  >
                    <span>📘</span> Facebook
                  </button>
                  <button 
                    type="button" 
                    className="ac-nd-btn-share zalo" 
                    onClick={handleShareZalo}
                    title="Chia sẻ qua Zalo"
                  >
                    <span>💬</span> Zalo
                  </button>
                  <button 
                    type="button" 
                    className="ac-nd-btn-share copy" 
                    onClick={handleCopyLink}
                    title="Sao chép liên kết"
                  >
                    <span>🔗</span> Copy Link
                  </button>
                  <button 
                    type="button" 
                    className="ac-nd-btn-share print" 
                    onClick={handlePrint}
                    title="In bài viết"
                  >
                    <span>🖨️</span> In
                  </button>
                </div>

                <div className="ac-nd-font-controls">
                  <span className="ac-nd-font-label">Cỡ chữ:</span>
                  <button 
                    type="button" 
                    className={`ac-btn-font ${fontScale === 0.9 ? 'active' : ''}`}
                    onClick={() => setFontScale(0.9)}
                    title="Cỡ chữ nhỏ"
                  >
                    A-
                  </button>
                  <button 
                    type="button" 
                    className={`ac-btn-font ${fontScale === 1 ? 'active' : ''}`}
                    onClick={() => setFontScale(1)}
                    title="Cỡ chữ chuẩn"
                  >
                    A
                  </button>
                  <button 
                    type="button" 
                    className={`ac-btn-font ${fontScale === 1.15 ? 'active' : ''}`}
                    onClick={() => setFontScale(1.15)}
                    title="Cỡ chữ lớn"
                  >
                    A+
                  </button>
                </div>
              </div>

              {/* Lead / Sapo Description */}
              {tintuc.description && (
                <div className="ac-nd-sapo">
                  <p>{tintuc.description}</p>
                </div>
              )}

              {/* Featured Image */}
              {tintuc.image && (
                <figure className="ac-nd-hero-figure">
                  <img 
                    src={resolveImage(tintuc.image)} 
                    alt={tintuc.name} 
                    className="ac-nd-hero-img"
                  />
                  <figcaption className="ac-nd-hero-caption">
                    Hình ảnh minh họa thực tế tại hệ thống tổng kho MayLanhGiaKho
                  </figcaption>
                </figure>
              )}

              {/* Dynamic Table of Contents (TOC) */}
              {toc.length > 0 && (
                <nav className="ac-nd-toc" aria-label="Mục lục bài viết">
                  <div className="ac-nd-toc-header" onClick={() => setIsTocOpen(!isTocOpen)}>
                    <div className="ac-nd-toc-title">
                      <span>📑</span>
                      <strong>Mục Lục Bài Viết</strong>
                      <span className="ac-nd-toc-count">({toc.length} mục)</span>
                    </div>
                    <button type="button" className="ac-nd-toc-toggle-btn">
                      {isTocOpen ? 'Thu gọn ▲' : 'Mở rộng ▼'}
                    </button>
                  </div>

                  {isTocOpen && (
                    <ol className="ac-nd-toc-list">
                      {toc.map((item, idx) => (
                        <li key={item.id} className={`ac-nd-toc-item level-${item.level}`}>
                          <button 
                            type="button"
                            onClick={() => scrollToHeading(item.id)}
                            className="ac-nd-toc-link"
                          >
                            <span className="ac-nd-toc-num">{idx + 1}.</span> {item.text}
                          </button>
                        </li>
                      ))}
                    </ol>
                  )}
                </nav>
              )}

              {/* Rich Body Content */}
              <div 
                ref={contentRef}
                className="ac-nd-body-content"
                style={{ fontSize: `${fontScale * 16.5}px` }}
                dangerouslySetInnerHTML={{ __html: tintuc.detail_descriptions || '<p>Nội dung đang được cập nhật...</p>' }}
              />

              {/* Reassurance Callout Box Inside Content */}
              <div className="ac-nd-guarantee-box">
                <div className="ac-nd-gb-icon">🛡️</div>
                <div className="ac-nd-gb-text">
                  <h4>Cam Kết Từ Tổng Kho MayLanhGiaKho</h4>
                  <p>
                    Tất cả sản phẩm máy lạnh do MayLanhGiaKho phân phối đều là hàng chính hãng mới 100%, nguyên đai nguyên kiện, 
                    kích hoạt bảo hành điện tử chính hãng tận nhà. Khảo sát và lắp đặt chuẩn kỹ thuật trong 2h tại TP.HCM.
                  </p>
                  <div className="ac-nd-gb-hotline">
                    <span>Tổng đài tư vấn kỹ thuật miễn phí: </span>
                    <a href="tel:0583593999"><strong>0583 593 999</strong></a>
                  </div>
                </div>
              </div>

              {/* Feedback Section */}
              <div className="ac-nd-feedback-wrap">
                <div className="ac-nd-feedback-title">
                  Bài viết này có hữu ích cho bạn không?
                </div>
                {feedbackGiven ? (
                  <div className="ac-nd-feedback-thanks">
                    🎉 Cảm ơn bạn đã phản hồi! MayLanhGiaKho luôn nỗ lực chia sẻ kiến thức hữu ích nhất.
                  </div>
                ) : (
                  <div className="ac-nd-feedback-buttons">
                    <button 
                      type="button" 
                      className="ac-btn-feedback yes" 
                      onClick={() => setFeedbackGiven('yes')}
                    >
                      👍 Rất hữu ích
                    </button>
                    <button 
                      type="button" 
                      className="ac-btn-feedback no" 
                      onClick={() => setFeedbackGiven('no')}
                    >
                      💬 Cần tư vấn thêm
                    </button>
                  </div>
                )}
              </div>

              {/* Article Footer Tags & Actions */}
              <div className="ac-nd-tags-row">
                <span className="ac-nd-tag-label">Từ khóa:</span>
                <span className="ac-nd-tag-item">#maylanhgiakho</span>
                <span className="ac-nd-tag-item">#tietkiemdien</span>
                <span className="ac-nd-tag-item">#maylanhinverter</span>
                <span className="ac-nd-tag-item">#camnangdienlanh</span>
              </div>
            </article>

            {/* Bottom Related Articles Section */}
            {otherPosts.length > 0 && (
              <section className="ac-nd-bottom-related">
                <div className="ac-nd-section-title-wrap">
                  <h3 className="ac-nd-section-title">
                    <span>📚</span> Các Bài Viết Cùng Chuyên Mục Bạn Nên Xem
                  </h3>
                  <a href="/tintuc" className="ac-nd-view-all-link">
                    Xem tất cả bài viết →
                  </a>
                </div>

                <div className="ac-nd-bottom-grid">
                  {otherPosts.slice(0, 3).map((post) => (
                    <article key={post.id} className="ac-nd-subpost-card">
                      <a href={`/tintuc-detail/${post.slug}`} className="ac-nd-subpost-img-wrap">
                        <img 
                          src={resolveImage(post.image)} 
                          alt={post.name} 
                          loading="lazy" 
                        />
                      </a>
                      <div className="ac-nd-subpost-body">
                        <span className="ac-nd-subpost-date">
                          📅 {formatDate(post.created_at)}
                        </span>
                        <h4 className="ac-nd-subpost-title">
                          <a href={`/tintuc-detail/${post.slug}`}>{post.name}</a>
                        </h4>
                        <p className="ac-nd-subpost-desc">
                          {post.description ? (post.description.slice(0, 95) + '...') : 'Xem chi tiết cẩm nang máy lạnh hữu ích...'}
                        </p>
                        <a href={`/tintuc-detail/${post.slug}`} className="ac-nd-subpost-link">
                          Đọc ngay →
                        </a>
                      </div>
                    </article>
                  ))}
                </div>
              </section>
            )}

            {/* Quick Consultation Banner at Bottom */}
            <div className="ac-nd-bottom-cta">
              <div className="ac-nd-bcta-content">
                <span className="ac-nd-bcta-tag">Tư Vấn Miễn Phí 100%</span>
                <h3>Cần Tư Vấn Lắp Đặt Máy Lạnh Cho Gia Đình Hay Văn Phòng?</h3>
                <p>
                  Kỹ sư điện lạnh sẽ tính toán công suất chuẩn theo diện tích và hướng nắng, 
                  báo giá kho sỉ tốt nhất ngay trong hôm nay.
                </p>
                <div className="ac-nd-bcta-buttons">
                  <a href="tel:0583593999" className="ac-btn-cta-call">
                    <span>📞</span> Gọi Hotline: 0583 593 999
                  </a>
                  <a href="https://zalo.me/0583593999" target="_blank" rel="noopener noreferrer" className="ac-btn-cta-zalo">
                    Chat Zalo Báo Giá
                  </a>
                </div>
              </div>
            </div>
          </main>

          {/* RIGHT COLUMN: Sidebar (Sticky) */}
          <aside className="ac-nd-sidebar-col" aria-label="Thanh bên tin tức">
            {/* Widget 1: Hotline & Tư Vấn Nhanh */}
            <div className="ac-sidebar-card ac-sidebar-hotline-box">
              <span className="ac-side-badge">⚡ Phục Vụ 24/7</span>
              <h4>Tổng Kho Máy Lạnh Giá Sỉ</h4>
              <p>Cam kết giá rẻ nhất thị trường. Giao hàng & lắp đặt nhanh chóng tại TP.HCM và các tỉnh lân cận.</p>
              
              <a href="tel:0583593999" className="ac-side-hotline-btn">
                <span>📞</span> 0583 593 999
              </a>
              <a href="tel:0353353286" className="ac-side-hotline-btn secondary">
                <span>📞</span> 0353 353 286
              </a>
              <a 
                href="https://zalo.me/0583593999" 
                target="_blank" 
                rel="noopener noreferrer" 
                className="ac-side-zalo-btn"
              >
                Nhắn Zalo Nhận Báo Giá Sỉ
              </a>

              <div className="ac-side-commit-list">
                <div className="ac-side-commit-item">✓ Hàng mới 100% nguyên đai kiện</div>
                <div className="ac-side-commit-item">✓ Kích hoạt bảo hành điện tử chính hãng</div>
                <div className="ac-side-commit-item">✓ Miễn phí vận chuyển nội thành</div>
              </div>
            </div>

            {/* Widget 2: Featured AC Products */}
            {featuredProducts.length > 0 && (
              <div className="ac-sidebar-card ac-nd-side-products">
                <div className="ac-nd-widget-head">
                  <h4 className="ac-side-card-title">🔥 Máy Lạnh Giá Sỉ Bán Chạy</h4>
                  <a href="/" className="ac-nd-widget-more">Xem thêm</a>
                </div>
                
                <div className="ac-nd-side-prod-list">
                  {featuredProducts.map((prod) => {
                    const priceNum = Number(prod.price) || 0;
                    const saleNum = Number(prod.price_sale) || priceNum;
                    const hasDiscount = priceNum > saleNum && saleNum > 0;

                    return (
                      <a 
                        key={prod.id} 
                        href={`/san-pham/${prod.slug}`} 
                        className="ac-nd-side-prod-item"
                      >
                        <div className="ac-nd-side-prod-img">
                          <img src={resolveImage(prod.thumb)} alt={prod.name} loading="lazy" />
                          {hasDiscount && (
                            <span className="ac-nd-side-prod-disc">Giảm sốc</span>
                          )}
                        </div>
                        <div className="ac-nd-side-prod-info">
                          <h5 className="ac-nd-side-prod-name">{prod.name}</h5>
                          <div className="ac-nd-side-prod-price">
                            <span className="ac-nd-price-current">{formatVND(saleNum)}</span>
                            {hasDiscount && (
                              <span className="ac-nd-price-old">{formatVND(priceNum)}</span>
                            )}
                          </div>
                          <span className="ac-nd-side-prod-btn">Xem chi tiết →</span>
                        </div>
                      </a>
                    );
                  })}
                </div>
              </div>
            )}

            {/* Widget 3: Quick Service Price List */}
            <div className="ac-sidebar-card ac-side-promo-card">
              <span className="ac-side-badge-blue">Dịch Vụ Trọn Gói</span>
              <h4>Bảng Giá Lắp Đặt & Vệ Sinh</h4>
              <p>Đội thợ kỹ thuật chuyên nghiệp, tay nghề cao, phục vụ tận tâm, giá minh bạch công khai.</p>
              
              <ul className="ac-nd-service-mini-list">
                <li>
                  <span>Vệ sinh máy lạnh treo tường:</span>
                  <strong>Từ 150.000đ</strong>
                </li>
                <li>
                  <span>Công lắp đặt máy lạnh:</span>
                  <strong>Từ 300.000đ</strong>
                </li>
                <li>
                  <span>Nạp gas máy lạnh R32 / R410A:</span>
                  <strong>Từ 200.000đ</strong>
                </li>
              </ul>

              <a href="/banggia" className="ac-side-btn-view-price">
                Xem bảng giá chi tiết →
              </a>
            </div>

            {/* Widget 4: More Related Articles in Sidebar */}
            {otherPosts.length > 3 && (
              <div className="ac-sidebar-card">
                <h4 className="ac-side-card-title">📰 Bài Viết Mới Nhất</h4>
                <div className="ac-nd-side-articles">
                  {otherPosts.slice(3, 8).map((post) => (
                    <a 
                      key={post.id} 
                      href={`/tintuc-detail/${post.slug}`} 
                      className="ac-nd-side-article-item"
                    >
                      <div className="ac-nd-side-article-thumb">
                        <img src={resolveImage(post.image)} alt={post.name} loading="lazy" />
                      </div>
                      <div className="ac-nd-side-article-info">
                        <h6>{post.name}</h6>
                        <span>📅 {formatDate(post.created_at)}</span>
                      </div>
                    </a>
                  ))}
                </div>
              </div>
            )}
          </aside>
        </div>
      </div>
    </div>
  );
}
