import React, { useState, useEffect } from 'react';

export default function FooterApp({ initialData = {} }) {
  const hotline = initialData.hotline || '0583593999';
  const hotlineSub = initialData.hotline_sub || '0582831111';
  const email = initialData.email || 'dienmayphanhoa83@gmail.com';
  const address = initialData.address || '582 An Dương Vương, Bình Phú, TP. Hồ Chí Minh';
  const workingHours = initialData.working_hours || '7:30 - 21:00 (Thứ 2 - CN & Lễ)';

  const [newsletterEmail, setNewsletterEmail] = useState('');
  const [newsletterStatus, setNewsletterStatus] = useState(null); // 'success', 'error'
  const [showBackToTop, setShowBackToTop] = useState(false);
  const [toast, setToast] = useState(null);

  // Monitor scroll for back-to-top button
  useEffect(() => {
    const handleScroll = () => {
      setShowBackToTop(window.scrollY > 350);
    };
    window.addEventListener('scroll', handleScroll, { passive: true });
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const scrollToTop = () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth',
    });
  };

  const handleSubscribe = (e) => {
    e.preventDefault();
    const trimmed = newsletterEmail.trim();
    if (!trimmed || !trimmed.includes('@') || !trimmed.includes('.')) {
      setNewsletterStatus('error');
      setToast('Vui lòng nhập địa chỉ email hợp lệ!');
      setTimeout(() => setToast(null), 3000);
      return;
    }

    setNewsletterStatus('success');
    setToast('Cảm ơn bạn đã đăng ký nhận bản tin khuyến mãi từ MayLanhGiaKho!');
    setNewsletterEmail('');
    setTimeout(() => {
      setNewsletterStatus(null);
      setToast(null);
    }, 5000);
  };

  const handleCopyHotline = () => {
    if (navigator.clipboard) {
      navigator.clipboard.writeText(hotline);
      setToast('Đã sao chép số hotline 0583.593.999!');
      setTimeout(() => setToast(null), 3000);
    }
  };

  return (
    <footer className="ac-main-footer" role="contentinfo">
      {/* Toast Alert */}
      {toast && (
        <div className="ac-footer-toast" role="status">
          <span className="ac-toast-icon">✓</span>
          <span>{toast}</span>
        </div>
      )}

      {/* 1. Top Reassurance Strip (Cam kết vàng tại kho) */}
      <div className="ac-footer-trust-strip">
        <div className="ac-container">
          <div className="ac-footer-trust-grid">
            <div className="ac-ft-item">
              <div className="ac-ft-icon">🛡️</div>
              <div className="ac-ft-text">
                <strong>100% Chính Hãng</strong>
                <p>Nguyên đai nguyên kiện, bảo hành điện tử tận nhà</p>
              </div>
            </div>

            <div className="ac-ft-item">
              <div className="ac-ft-icon">🏷️</div>
              <div className="ac-ft-text">
                <strong>Tổng Kho Giá Sỉ</strong>
                <p>Tiết kiệm 15% - 25% so với siêu thị điện máy</p>
              </div>
            </div>

            <div className="ac-ft-item">
              <div className="ac-ft-icon">🚚</div>
              <div className="ac-ft-text">
                <strong>Giao & Lắp Trong 2H</strong>
                <p>Đội ngũ kỹ thuật viên cơ điện lạnh chuyên nghiệp</p>
              </div>
            </div>

            <div className="ac-ft-item">
              <div className="ac-ft-icon">🔄</div>
              <div className="ac-ft-text">
                <strong>Đổi Mới 30 Ngày</strong>
                <p>Lỗi nhà sản xuất 1 đổi 1 nhanh chóng trong 24h</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* 2. Main 4-Column Footer Content */}
      <div className="ac-footer-main">
        <div className="ac-container">
          <div className="ac-footer-grid">
            {/* Column 1: Company Profile & Contact */}
            <div className="ac-fcol ac-fcol-brand">
              <div className="ac-flogo-wrap">
                <a href="/" className="ac-flogo-link">
                  <img 
                    src="/template/images/icons/iconml.png" 
                    alt="MayLanhGiaKho - Tổng Kho Máy Lạnh Chính Hãng" 
                    className="ac-flogo-img"
                  />
                  <div className="ac-flogo-text">
                    <span className="brand-name">MayLanhGiaKho</span>
                    <span className="brand-tag">Tổng Kho Phân Phối Giá Sỉ</span>
                  </div>
                </a>
              </div>

              <p className="ac-fdesc">
                Hệ thống tổng kho phân phối máy lạnh Daikin, Panasonic, Toshiba, Casper, Mitsubishi chính hãng 
                giá sỉ tận kho, phục vụ lắp đặt và bảo dưỡng trọn gói tại TP.HCM và các tỉnh lân cận.
              </p>

              <div className="ac-fcontact-list">
                <div className="ac-fcontact-item">
                  <span className="ac-fc-icon">📍</span>
                  <div>
                    <strong>Địa chỉ kho:</strong>
                    <a href="/contact" className="ac-fcontact-link">{address}</a>
                  </div>
                </div>

                <div className="ac-fcontact-item">
                  <span className="ac-fc-icon">📞</span>
                  <div>
                    <strong>Hotline mua hàng & kỹ thuật:</strong>
                    <div className="ac-hotline-pills">
                      <a href={`tel:${hotline}`} className="ac-hpill primary">0583.593.999</a>
                      <a href={`tel:${hotlineSub}`} className="ac-hpill secondary">0582.83.1111</a>
                    </div>
                  </div>
                </div>

                <div className="ac-fcontact-item">
                  <span className="ac-fc-icon">💬</span>
                  <div>
                    <strong>Tư vấn Zalo 24/7:</strong>
                    <a 
                      href="https://zalo.me/0583593999" 
                      target="_blank" 
                      rel="noopener noreferrer"
                      className="ac-zalo-link"
                    >
                      0583 593 999 (Nhận Báo Giá Sỉ)
                    </a>
                  </div>
                </div>

                <div className="ac-fcontact-item">
                  <span className="ac-fc-icon">⏰</span>
                  <div>
                    <strong>Giờ hoạt động:</strong>
                    <span>{workingHours}</span>
                  </div>
                </div>
              </div>
            </div>

            {/* Column 2: Policies & Regulations */}
            <div className="ac-fcol">
              <h4 className="ac-fcol-title">Chính Sách & Quy Định</h4>
              <ul className="ac-flinks">
                <li>
                  <a href="/chinh-sach-bao-hanh">
                    <span className="bullet">›</span> Chính sách bảo hành chính hãng
                  </a>
                </li>
                <li>
                  <a href="/chinh-sach-van-chuyen">
                    <span className="bullet">›</span> Chính sách giao hàng & vận chuyển
                  </a>
                </li>
                <li>
                  <a href="/chinh-sach-doi-tra">
                    <span className="bullet">›</span> Chính sách đổi trả & hoàn tiền
                  </a>
                </li>
                <li>
                  <a href="/chinh-sach-bo-mat-thong-tin">
                    <span className="bullet">›</span> Chính sách bảo mật thông tin
                  </a>
                </li>
                <li>
                  <a href="/chinh-sach-tuyen-dung">
                    <span className="bullet">›</span> Chính sách tuyển dụng thợ điện lạnh
                  </a>
                </li>
                <li>
                  <a href="/contact">
                    <span className="bullet">›</span> Báo giá máy lạnh công trình & dự án
                  </a>
                </li>
              </ul>
            </div>

            {/* Column 3: Help & Services */}
            <div className="ac-fcol">
              <h4 className="ac-fcol-title">Dịch Vụ & Hỗ Trợ</h4>
              <ul className="ac-flinks">
                <li>
                  <a href="/dichvu">
                    <span className="bullet">›</span> Dịch vụ lắp đặt máy lạnh trọn gói
                  </a>
                </li>
                <li>
                  <a href="/dichvu">
                    <span className="bullet">›</span> Vệ sinh & xịt rửa bảo dưỡng máy lạnh
                  </a>
                </li>
                <li>
                  <a href="/dichvu">
                    <span className="bullet">›</span> Nạp gas chuẩn chính hãng R32 / R410A
                  </a>
                </li>
                <li>
                  <a href="/banggia">
                    <span className="bullet">›</span> Bảng giá nhân công & vật tư ống đồng
                  </a>
                </li>
                <li>
                  <a href="/tintuc">
                    <span className="bullet">›</span> Cẩm nang tính công suất phòng (HP / m²)
                  </a>
                </li>
                <li>
                  <a href="/dichvu">
                    <span className="bullet">›</span> Hỗ trợ di dời máy lạnh (Học sinh - SV giảm 20%)
                  </a>
                </li>
                <li>
                  <a href="/contact">
                    <span className="bullet">›</span> Câu hỏi thường gặp & Hướng dẫn sử dụng
                  </a>
                </li>
              </ul>
            </div>

            {/* Column 4: Newsletter & Certifications */}
            <div className="ac-fcol ac-fcol-newsletter">
              <h4 className="ac-fcol-title">Đăng Ký Bản Tin</h4>
              <p className="ac-fnews-desc">
                Nhận thông báo ưu đãi giá sỉ tại kho và cẩm nang sử dụng máy lạnh tiết kiệm điện 40% hàng tháng.
              </p>

              <form onSubmit={handleSubscribe} className="ac-fnewsletter-form">
                <div className="ac-finput-group">
                  <input
                    type="email"
                    value={newsletterEmail}
                    onChange={(e) => setNewsletterEmail(e.target.value)}
                    placeholder="Nhập email của bạn..."
                    aria-label="Email nhận bản tin"
                    required
                  />
                  <button type="submit" className="ac-fbtn-sub">
                    Đăng Ký
                  </button>
                </div>
              </form>

              {newsletterStatus === 'success' && (
                <div className="ac-fnews-success">
                  ✓ Đăng ký thành công! Cảm ơn quý khách.
                </div>
              )}

              {/* Trust Badges & Certifications */}
              <div className="ac-fcert-wrap">
                <span className="ac-fcert-title">Chứng Nhận An Toàn:</span>
                <div className="ac-fcert-badges">
                  {/* DMCA Badge */}
                  <a
                    href="//www.dmca.com/Protection/Status.aspx?ID=7ecbab4a-2360-4557-a452-9ed0e770131a"
                    title="DMCA.com Protection Status"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="ac-dmca-badge"
                  >
                    <img
                      src="https://images.dmca.com/Badges/dmca_protected_sml_120p.png?ID=7ecbab4a-2360-4557-a452-9ed0e770131a"
                      alt="DMCA Protected"
                    />
                  </a>

                  {/* Genuine Guarantee Badge */}
                  <div className="ac-genuine-badge">
                    <span>100% CHÍNH HÃNG</span>
                  </div>
                </div>
              </div>

              {/* Payment Methods */}
              <div className="ac-fpay-wrap">
                <span className="ac-fpay-title">Phương Thức Thanh Toán:</span>
                <div className="ac-fpay-methods">
                  <span className="ac-pay-item" title="Thanh toán khi nhận hàng (COD)">💵 Tiền mặt</span>
                  <span className="ac-pay-item" title="Chuyển khoản ngân hàng 24/7">🏦 Chuyển khoản</span>
                  <span className="ac-pay-item" title="Quẹt thẻ tận nơi">💳 Thẻ Visa/Master</span>
                  <span className="ac-pay-item" title="Hỗ trợ trả góp 0%">📑 Trả góp 0%</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* 3. Bottom Copyright & Social Bar */}
      <div className="ac-footer-bottom">
        <div className="ac-container">
          <div className="ac-fb-content">
            <p className="ac-fcopy">
              © {new Date().getFullYear()} <strong>MayLanhGiaKho.vn</strong> - Tổng Kho Máy Lạnh Chính Hãng Giá Sỉ Tại TP.HCM. Bảo lưu mọi quyền.
            </p>

            <div className="ac-fsocials">
              <a 
                href="https://facebook.com" 
                target="_blank" 
                rel="noopener noreferrer" 
                className="ac-fsoc-link fb"
                title="Facebook MayLanhGiaKho"
              >
                <i className="fa fa-facebook"></i>
              </a>
              <a 
                href="https://zalo.me/0583593999" 
                target="_blank" 
                rel="noopener noreferrer" 
                className="ac-fsoc-link zalo"
                title="Zalo MayLanhGiaKho"
              >
                <span style={{ fontSize: 11, fontWeight: 900 }}>Zalo</span>
              </a>
              <a 
                href="https://youtube.com" 
                target="_blank" 
                rel="noopener noreferrer" 
                className="ac-fsoc-link yt"
                title="YouTube MayLanhGiaKho"
              >
                <i className="fa fa-youtube-play"></i>
              </a>
              <a 
                href={`tel:${hotline}`} 
                className="ac-fsoc-link phone"
                title="Gọi Hotline"
              >
                <i className="fa fa-phone"></i>
              </a>
            </div>
          </div>
        </div>
      </div>

      {/* 4. Smooth Back To Top Floating Button */}
      {showBackToTop && (
        <button
          type="button"
          className="ac-btn-scroll-top"
          onClick={scrollToTop}
          title="Lên đầu trang"
          aria-label="Lên đầu trang"
        >
          <i className="fa fa-chevron-up"></i>
        </button>
      )}
    </footer>
  );
}
