import React, { useState, useEffect } from 'react';

const POLICIES = [
  {
    id: 'bao-hanh',
    slug: '/chinh-sach-bao-hanh',
    title: 'Chính Sách Bảo Hành',
    shortDesc: 'Cam kết bảo hành chính hãng từ nhà sản xuất, kích hoạt bảo hành điện tử tại nhà.',
    badge: 'Chính hãng 100%',
    icon: '🛡️',
  },
  {
    id: 'van-chuyen',
    slug: '/chinh-sach-van-chuyen',
    title: 'Chính Sách Vận Chuyển',
    shortDesc: 'Giao hàng hỏa tốc trong 2H - 3H, miễn phí nội thành TP.HCM, an toàn nguyên đai nguyên kiện.',
    badge: 'Giao Siêu Tốc 2H',
    icon: '🚚',
  },
  {
    id: 'doi-tra',
    slug: '/chinh-sach-doi-tra',
    title: 'Chính Sách Đổi Trả',
    shortDesc: 'Lỗi 1 đổi 1 trong 30 - 35 ngày, hỗ trợ đổi model linh hoạt, thủ tục nhanh chóng.',
    badge: 'Đổi Mới 30 Ngày',
    icon: '🔄',
  },
  {
    id: 'bao-mat',
    slug: '/chinh-sach-bo-mat-thong-tin',
    title: 'Chính Sách Bảo Mật',
    shortDesc: 'Bảo mật tuyệt đối thông tin khách hàng, tuân thủ tiêu chuẩn an toàn dữ liệu và SSL 256-bit.',
    badge: 'An Toàn Tuyệt Đối',
    icon: '🔒',
  },
  {
    id: 'tuyen-dung',
    slug: '/chinh-sach-tuyen-dung',
    title: 'Thông Báo Tuyển Dụng',
    shortDesc: 'Điện máy Phan Hòa tuyển dụng Kế toán, Thợ lắp đặt, Giao hàng, Điều phối với đãi ngộ cao.',
    badge: 'Đang Tuyển Gấp',
    icon: '💼',
  },
];

export default function PolicyApp({ initialData = {} }) {
  const getInitialPolicy = () => {
    if (initialData.policyKey) return initialData.policyKey;
    const path = window.location.pathname;
    if (path.includes('chinh-sach-van-chuyen')) return 'van-chuyen';
    if (path.includes('chinh-sach-doi-tra')) return 'doi-tra';
    if (path.includes('chinh-sach-bo-mat') || path.includes('chinh-sach-bao-mat')) return 'bao-mat';
    if (path.includes('chinh-sach-tuyen-dung')) return 'tuyen-dung';
    return 'bao-hanh';
  };

  const [activePolicy, setActivePolicy] = useState(getInitialPolicy);
  const [searchQuery, setSearchQuery] = useState('');
  const [toastMessage, setToastMessage] = useState(null);
  const [applyModalJob, setApplyModalJob] = useState(null);
  const [applyForm, setApplyForm] = useState({ name: '', phone: '', experience: '', note: '' });

  const hotline = initialData.hotline || '0583 593 999';
  const hotlineSub = initialData.hotline_sub || '0353 353 286';
  const recruitmentHotline = '039 6789 012';
  const address = initialData.address || '582 An Dương Vương, Bình Phú, TP. Hồ Chí Minh';
  const email = initialData.email || 'Phanvanhoa231102@gmail.com';

  // Synchronize browser history and title
  useEffect(() => {
    const handlePopState = () => {
      const path = window.location.pathname;
      if (path.includes('chinh-sach-van-chuyen')) setActivePolicy('van-chuyen');
      else if (path.includes('chinh-sach-doi-tra')) setActivePolicy('doi-tra');
      else if (path.includes('chinh-sach-bo-mat') || path.includes('chinh-sach-bao-mat')) setActivePolicy('bao-mat');
      else if (path.includes('chinh-sach-tuyen-dung')) setActivePolicy('tuyen-dung');
      else setActivePolicy('bao-hanh');
    };

    window.addEventListener('popstate', handlePopState);
    return () => window.removeEventListener('popstate', handlePopState);
  }, []);

  const switchPolicy = (policyId) => {
    setActivePolicy(policyId);
    const target = POLICIES.find((p) => p.id === policyId);
    if (target && window.location.pathname !== target.slug) {
      window.history.pushState(null, '', target.slug);
      document.title = `${target.title} - MayLanhGiaKho`;
    }
    // Scroll gently to top of policy content
    const contentElement = document.getElementById('policy-main-viewport');
    if (contentElement) {
      contentElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  };

  const showToast = (msg) => {
    setToastMessage(msg);
    setTimeout(() => setToastMessage(null), 3500);
  };

  const handleCopyLink = () => {
    if (navigator.clipboard) {
      navigator.clipboard.writeText(window.location.href);
      showToast('Đã sao chép liên kết chính sách vào bộ nhớ tạm!');
    }
  };

  const handlePrint = () => {
    window.print();
  };

  const handleApplySubmit = (e) => {
    e.preventDefault();
    if (!applyForm.name || !applyForm.phone) {
      showToast('Vui lòng điền họ tên và số điện thoại!');
      return;
    }
    showToast(`Cảm ơn ${applyForm.name}! Thông tin ứng tuyển vị trí ${applyModalJob} đã được ghi nhận. Chúng tôi sẽ gọi lại sớm nhất.`);
    setApplyModalJob(null);
    setApplyForm({ name: '', phone: '', experience: '', note: '' });
  };

  const currentPolicyObj = POLICIES.find((p) => p.id === activePolicy) || POLICIES[0];

  return (
    <div className="ac-policy-wrapper">
      {/* Toast Notification */}
      {toastMessage && (
        <div className="ac-policy-toast" role="status">
          <span className="toast-icon">✓</span>
          <span>{toastMessage}</span>
        </div>
      )}

      {/* 1. Hero Header Banner */}
      <section className="ac-policy-hero">
        <div className="ac-container">
          <div className="ac-policy-hero-inner">
            <nav className="ac-policy-breadcrumbs" aria-label="Breadcrumb">
              <a href="/">Trang Chủ</a>
              <span className="bc-separator">/</span>
              <span>Chính Sách & Quy Định</span>
              <span className="bc-separator">/</span>
              <span className="bc-active">{currentPolicyObj.title}</span>
            </nav>

            <div className="ac-policy-hero-badge">
              <span>{currentPolicyObj.badge}</span>
            </div>

            <h1 className="ac-policy-hero-title">
              {currentPolicyObj.title}
            </h1>

            <p className="ac-policy-hero-desc">
              {currentPolicyObj.shortDesc}
            </p>

            {/* Quick search input */}
            <div className="ac-policy-quick-search">
              <span className="search-icon">🔍</span>
              <input
                type="text"
                placeholder="Tìm từ khóa trong chính sách (bảo hành, đổi trả, phí ship, kế toán, thợ máy...)..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                aria-label="Tìm kiếm chính sách"
              />
              {searchQuery && (
                <button
                  type="button"
                  className="clear-search"
                  onClick={() => setSearchQuery('')}
                >
                  ✕
                </button>
              )}
            </div>
          </div>
        </div>
      </section>

      {/* 2. Main 2-Column Content Layout */}
      <section className="ac-policy-container" id="policy-main-viewport">
        <div className="ac-container">
          <div className="ac-policy-layout">
            {/* Sidebar Navigation */}
            <aside className="ac-policy-sidebar">
              <div className="ac-policy-nav-box">
                <h3 className="ac-sidebar-title">
                  <span>Danh Mục Chính Sách</span>
                </h3>
                <ul className="ac-policy-nav-list">
                  {POLICIES.map((policy) => {
                    const isActive = activePolicy === policy.id;
                    return (
                      <li key={policy.id}>
                        <button
                          type="button"
                          className={`ac-policy-nav-item ${isActive ? 'active' : ''}`}
                          onClick={() => switchPolicy(policy.id)}
                        >
                          <span className="item-icon">{policy.icon}</span>
                          <div className="item-details">
                            <span className="item-title">{policy.title}</span>
                            <span className="item-badge">{policy.badge}</span>
                          </div>
                          {isActive && <span className="item-indicator">●</span>}
                        </button>
                      </li>
                    );
                  })}
                </ul>
              </div>

              {/* Quick Contact & Consultation Card */}
              <div className="ac-policy-contact-card">
                <div className="card-header">
                  <span className="card-icon">📞</span>
                  <strong>Cần Hỗ Trợ Nhanh?</strong>
                </div>
                <p>Đội ngũ chuyên viên kỹ thuật và bán hàng tại kho hỗ trợ 24/7:</p>
                <div className="contact-buttons">
                  <a href={`tel:${hotline.replace(/\s+/g, '')}`} className="btn-call primary">
                    <span>Hotline:</span> {hotline}
                  </a>
                  <a href={`tel:${hotlineSub.replace(/\s+/g, '')}`} className="btn-call secondary">
                    <span>Kỹ Thuật:</span> {hotlineSub}
                  </a>
                  <a
                    href="https://zalo.me/0583593999"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn-zalo"
                  >
                    <span>Chat Zalo Báo Giá</span>
                  </a>
                </div>
              </div>

              {/* Warehouse Address Badge */}
              <div className="ac-policy-address-card">
                <span className="addr-icon">📍</span>
                <div className="addr-info">
                  <strong>Tổng Kho Điện Máy:</strong>
                  <p>{address}</p>
                  <small>Giờ mở cửa: 7:30 - 21:00 (Cả CN & Lễ)</small>
                </div>
              </div>
            </aside>

            {/* Main Policy Content Area */}
            <main className="ac-policy-content-area">
              <div className="ac-policy-card">
                {/* Policy Action Bar (Print, Copy Link, Last Updated) */}
                <div className="ac-policy-action-bar">
                  <div className="policy-meta-info">
                    <span className="meta-tag">Áp dụng từ: 01/2026</span>
                    <span className="meta-dot">•</span>
                    <span className="meta-tag">Hệ thống MayLanhGiaKho & Điện Máy Phan Hòa</span>
                  </div>

                  <div className="policy-action-buttons">
                    <button
                      type="button"
                      onClick={handleCopyLink}
                      className="btn-action"
                      title="Sao chép đường dẫn"
                    >
                      🔗 Sao chép link
                    </button>
                    <button
                      type="button"
                      onClick={handlePrint}
                      className="btn-action"
                      title="In văn bản chính sách"
                    >
                      🖨️ In văn bản
                    </button>
                  </div>
                </div>

                {/* Render the Active Policy Content */}
                {activePolicy === 'bao-hanh' && (
                  <WarrantyPolicyView
                    hotline={hotline}
                    searchQuery={searchQuery}
                  />
                )}

                {activePolicy === 'van-chuyen' && (
                  <ShippingPolicyView
                    hotline={hotline}
                    searchQuery={searchQuery}
                  />
                )}

                {activePolicy === 'doi-tra' && (
                  <ReturnPolicyView
                    hotline={hotline}
                    searchQuery={searchQuery}
                  />
                )}

                {activePolicy === 'bao-mat' && (
                  <PrivacyPolicyView
                    email={email}
                    hotline={hotline}
                    searchQuery={searchQuery}
                  />
                )}

                {activePolicy === 'tuyen-dung' && (
                  <RecruitmentPolicyView
                    address={address}
                    hotline={hotline}
                    recruitmentHotline={recruitmentHotline}
                    searchQuery={searchQuery}
                    onOpenApplyModal={(jobTitle) => setApplyModalJob(jobTitle)}
                  />
                )}

                {/* Bottom Assurance Commitment Card */}
                <div className="ac-policy-footer-reassurance">
                  <div className="reassurance-grid">
                    <div className="r-item">
                      <span className="r-icon">🛡️</span>
                      <div>
                        <strong>100% Chính Hãng</strong>
                        <p>Kích hoạt bảo hành điện tử chính hãng</p>
                      </div>
                    </div>
                    <div className="r-item">
                      <span className="r-icon">🏷️</span>
                      <div>
                        <strong>Giá Sỉ Tại Kho</strong>
                        <p>Cam kết giá tốt nhất thị trường</p>
                      </div>
                    </div>
                    <div className="r-item">
                      <span className="r-icon">🚚</span>
                      <div>
                        <strong>Giao Lắp Tận Nơi</strong>
                        <p>Kỹ thuật viên lành nghề chuẩn cơ điện lạnh</p>
                      </div>
                    </div>
                    <div className="r-item">
                      <span className="r-icon">🔄</span>
                      <div>
                        <strong>Đổi Mới 30 Ngày</strong>
                        <p>Lỗi nhà sản xuất 1 đổi 1 nhanh chóng</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </main>
          </div>
        </div>
      </section>

      {/* Recruitment Job Application Modal */}
      {applyModalJob && (
        <div className="ac-policy-modal-overlay" onClick={() => setApplyModalJob(null)}>
          <div className="ac-policy-modal" onClick={(e) => e.stopPropagation()}>
            <div className="modal-header">
              <h3>Ứng Tuyển Vị Trí: {applyModalJob}</h3>
              <button
                type="button"
                className="close-modal"
                onClick={() => setApplyModalJob(null)}
              >
                ✕
              </button>
            </div>

            <form onSubmit={handleApplySubmit} className="modal-body">
              <p className="modal-intro">
                Vui lòng để lại thông tin liên hệ. Phòng Nhân sự Điện Máy Phan Hòa sẽ liên hệ phỏng vấn trong vòng 24 giờ.
              </p>

              <div className="form-group">
                <label>Họ và Tên *</label>
                <input
                  type="text"
                  required
                  placeholder="Ví dụ: Nguyễn Văn An"
                  value={applyForm.name}
                  onChange={(e) => setApplyForm({ ...applyForm, name: e.target.value })}
                />
              </div>

              <div className="form-group">
                <label>Số Điện Thoại / Zalo *</label>
                <input
                  type="tel"
                  required
                  placeholder="Ví dụ: 0912 345 678"
                  value={applyForm.phone}
                  onChange={(e) => setApplyForm({ ...applyForm, phone: e.target.value })}
                />
              </div>

              <div className="form-group">
                <label>Kinh nghiệm làm việc</label>
                <select
                  value={applyForm.experience}
                  onChange={(e) => setApplyForm({ ...applyForm, experience: e.target.value })}
                >
                  <option value="">-- Chọn số năm kinh nghiệm --</option>
                  <option value="Chưa có kinh nghiệm (sẽ được đào tạo)">Chưa có kinh nghiệm (sẽ được đào tạo)</option>
                  <option value="Dưới 1 năm">Dưới 1 năm</option>
                  <option value="1 - 3 năm">1 - 3 năm</option>
                  <option value="Trên 3 năm">Trên 3 năm</option>
                </select>
              </div>

              <div className="form-group">
                <label>Ghi chú thêm (khu vực mong muốn, thời gian có thể đi làm)</label>
                <textarea
                  rows="3"
                  placeholder="Ví dụ: Có thể đi làm ngay, rành đường khu vực Quận 6, Bình Tân..."
                  value={applyForm.note}
                  onChange={(e) => setApplyForm({ ...applyForm, note: e.target.value })}
                />
              </div>

              <div className="modal-actions">
                <button type="button" className="btn-cancel" onClick={() => setApplyModalJob(null)}>
                  Hủy Bỏ
                </button>
                <button type="submit" className="btn-submit">
                  Gửi Hồ Sơ Ứng Tuyển
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}

/* ==========================================================================
   Sub-view 1: Warranty Policy View
   ========================================================================== */
function WarrantyPolicyView({ hotline }) {
  return (
    <div className="ac-policy-article">
      <div className="article-intro-box">
        <p>
          Chính sách bảo hành tại <strong>MayLanhGiaKho (Điện Máy Phan Hòa)</strong> được xây dựng nhằm bảo vệ tối đa
          quyền lợi của Quý khách hàng. Tất cả các sản phẩm máy lạnh (Daikin, Panasonic, Toshiba, Casper, Mitsubishi, v.v.)
          được bán ra đều là hàng <strong>chính hãng 100%, mới nguyên đai nguyên kiện</strong> và được hưởng chế độ bảo hành
          chính thức theo quy định của từng hãng sản xuất.
        </p>
      </div>

      {/* 4-Step Warranty Process */}
      <div className="ac-policy-steps-block">
        <h3 className="section-title">
          <span className="st-num">1</span> Quy Trình Tiếp Nhận & Xử Lý Bảo Hành 4 Bước
        </h3>
        <div className="steps-cards-grid">
          <div className="step-card">
            <div className="step-circle">1</div>
            <h4>Tiếp Nhận Thông Tin</h4>
            <p>Quý khách thông báo sự cố qua Hotline <a href={`tel:${hotline}`}>{hotline}</a> hoặc Zalo hỗ trợ kỹ thuật.</p>
          </div>

          <div className="step-card">
            <div className="step-circle">2</div>
            <h4>Xác Minh Trong 30P</h4>
            <p>Chuyên viên kỹ thuật liên hệ chẩn đoán từ xa và kiểm tra tình trạng kích hoạt bảo hành điện tử.</p>
          </div>

          <div className="step-card">
            <div className="step-circle">3</div>
            <h4>Kỹ Thuật Đến Tận Nhà</h4>
            <p>Kỹ thuật viên của hãng hoặc trạm bảo hành ủy quyền đến kiểm tra, xử lý hoặc thay linh kiện chính hãng.</p>
          </div>

          <div className="step-card">
            <div className="step-circle">4</div>
            <h4>Nghiệm Thu & Bàn Giao</h4>
            <p>Kiểm tra độ lạnh, thông số áp suất gas, vệ sinh sạch sẽ và bàn giao phiếu nghiệm thu cho khách hàng.</p>
          </div>
        </div>
      </div>

      {/* Section 2: Warranty Conditions */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">2</span> Điều Kiện Hưởng Chế Độ Bảo Hành Miễn Phí
        </h3>
        <ul className="styled-check-list">
          <li>
            <strong>Thời hạn bảo hành:</strong> Sản phẩm còn trong thời gian bảo hành hợp lệ, tính từ ngày mua hoặc ngày kích hoạt bảo hành điện tử.
          </li>
          <li>
            <strong>Nguồn gốc lỗi:</strong> Thiết bị phát sinh lỗi kỹ thuật do linh kiện hoặc lỗi từ quy trình lắp ráp của nhà sản xuất.
          </li>
          <li>
            <strong>Chứng từ hợp lệ:</strong> Có thông tin đơn hàng, số điện thoại đăng ký mua hàng hoặc số serial/IMEI khớp với hệ thống của hãng.
          </li>
          <li>
            <strong>Tem niêm phong:</strong> Tem bảo hành, mã QR, tem kiểm định của nhà sản xuất trên máy còn nguyên vẹn, không bị rách rời hay tẩy xóa.
          </li>
        </ul>
      </div>

      {/* Section 3: Exclusions */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">3</span> Các Trường Hợp Không Thuộc Diện Bảo Hành Miễn Phí
        </h3>
        <div className="notice-box danger">
          <ul>
            <li>Sản phẩm đã quá thời hạn bảo hành ghi trên phiếu bảo hành hoặc hệ thống điện tử.</li>
            <li>Hư hỏng do sử dụng sai hướng dẫn kỹ thuật, sai nguồn điện áp (như dùng sai điện áp 100V / 220V).</li>
            <li>Hư hỏng do thiên tai, sét đánh, lũ lụt, hỏa hoạn, ẩm mốc, côn trùng hoặc chuột bọ cắn phá dây dẫn.</li>
            <li>Sản phẩm đã bị tháo dỡ, can thiệp hoặc sửa chữa bởi thợ ngoài không thuộc hệ thống ủy quyền của hãng.</li>
            <li>Các hao mòn tự nhiên trong quá trình vận hành (như lưới lọc bụi, vỏ nhựa ngoài bị ố do ánh nắng).</li>
          </ul>
        </div>
      </div>

      {/* Section 4: Post-Warranty Services */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">4</span> Dịch Vụ Hậu Mãi & Cam Kết Hỗ Trợ Trọn Đời
        </h3>
        <p>
          Sau khi hết thời gian bảo hành miễn phí từ hãng, <strong>MayLanhGiaKho</strong> vẫn luôn đồng hành cùng Quý khách:
        </p>
        <ul className="styled-bullet-list">
          <li>Cung cấp linh kiện thay thế chính hãng với giá gốc hỗ trợ không tính lãi.</li>
          <li>Ưu đãi giảm <strong>20% - 30%</strong> chi phí vệ sinh, bảo dưỡng và nạp gas cho khách hàng đã từng mua máy tại kho.</li>
          <li>Hỗ trợ tư vấn kỹ thuật trực tuyến 24/7 qua Zalo và Hotline trọn đời máy.</li>
        </ul>
      </div>
    </div>
  );
}

/* ==========================================================================
   Sub-view 2: Shipping Policy View
   ========================================================================== */
function ShippingPolicyView({ hotline }) {
  return (
    <div className="ac-policy-article">
      <div className="article-intro-box">
        <p>
          <strong>MayLanhGiaKho</strong> tự hào sở hữu đội xe tải chuyên dụng và đội ngũ nhân viên giao hàng - lắp đặt
          chuyên nghiệp, cam kết giao máy lạnh đến tận nhà Quý khách nhanh chóng, an toàn và đúng hẹn tại khắp TP.HCM
          và các tỉnh lân cận.
        </p>
      </div>

      {/* Highlight Badges */}
      <div className="shipping-highlights-grid">
        <div className="sh-card">
          <span className="sh-icon">⏱️</span>
          <h4>Giao Hàng Siêu Tốc 2H</h4>
          <p>Có mặt lắp đặt chỉ sau 2 - 3 giờ chốt đơn nội thành TP.HCM.</p>
        </div>
        <div className="sh-card">
          <span className="sh-icon">🚚</span>
          <h4>Miễn Phí Vận Chuyển</h4>
          <p>Hỗ trợ miễn phí vận chuyển tận chân công trình/nhà ở tại TP.HCM.</p>
        </div>
        <div className="sh-card">
          <span className="sh-icon">📦</span>
          <h4>Bảo Hiểm Hàng Hóa 100%</h4>
          <p>Máy móc luôn mới nguyên đai nguyên kiện, chống móp méo trầy xước.</p>
        </div>
      </div>

      {/* Section 1: Scope */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">1</span> Phạm Vi Áp Dụng Vận Chuyển
        </h3>
        <p>
          Hệ thống phân phối phục vụ giao hàng trên toàn bộ 24 quận huyện TP. Hồ Chí Minh và các tỉnh thành lân cận
          (Bình Dương, Đồng Nai, Long An, Tây Ninh, Bà Rịa - Vũng Tàu).
        </p>
        <ul className="styled-check-list">
          <li><strong>Khu vực nội thành TP.HCM:</strong> Quận 1, 3, 4, 5, 6, 7, 8, 10, 11, Tân Bình, Tân Phú, Bình Thạnh, Phú Nhuận, Gò Vấp.</li>
          <li><strong>Khu vực ngoại thành & TP. Thủ Đức:</strong> Quận 12, Bình Tân, TP. Thủ Đức (Quận 2, Quận 9, Thủ Đức cũ), Nhà Bè, Bình Chánh, Hóc Môn, Củ Chi.</li>
          <li><strong>Khu vực liên tỉnh:</strong> Giao hàng theo lịch thỏa thuận hoặc gửi chành xe uy tín theo yêu cầu của khách hàng.</li>
        </ul>
      </div>

      {/* Section 2: Delivery Time */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">2</span> Thời Gian Giao Nhận & Lắp Đặt
        </h3>
        <ul className="styled-bullet-list">
          <li>Thời gian phục vụ giao nhận: Từ <strong>7:30 đến 21:00</strong> tất cả các ngày trong tuần (kể cả Thứ 7, Chủ Nhật và ngày Lễ).</li>
          <li>Thông thường, hàng sẽ được vận chuyển và kỹ thuật viên có mặt lắp đặt trong vòng <strong>2 - 3 giờ</strong> kể từ lúc xác nhận đơn hàng thành công.</li>
          <li>Đối với công trình hoặc khách hàng muốn hẹn giờ giao chính xác, đội ngũ điều phối sẽ lên lịch theo đúng khung giờ Quý khách mong muốn.</li>
          <li>Các đơn hàng cần giao gấp hỏa tốc, xin vui lòng gọi trực tiếp hotline <a href={`tel:${hotline}`}>{hotline}</a> để được ưu tiên xuất kho ngay.</li>
        </ul>
      </div>

      {/* Section 3: Inspection Checklist */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">3</span> Quy Trình Kiểm Tra & Nhận Hàng (Khuyến Nghị Khách Hàng)
        </h3>
        <div className="notice-box info">
          <p><strong>Để đảm bảo quyền lợi tối đa, khi nhân viên giao hàng đến, Quý khách vui lòng kiểm tra:</strong></p>
          <ol>
            <li>Thùng carton bọc dàn nóng và dàn lạnh còn nguyên seal, băng keo nhà máy, không bị rách nát hoặc ngấm nước.</li>
            <li>Tem phụ tiếng Việt ghi rõ nguồn gốc xuất xứ (Thái Lan, Malaysia, Indonesia, Việt Nam, v.v.) và thông số model trùng với đơn đặt hàng.</li>
            <li>Đầy đủ các phụ kiện tiêu chuẩn: Remote (điều khiển từ xa), pin, sách hướng dẫn sử dụng, phiếu bảo hành (nếu có).</li>
            <li>Kỹ thuật viên tiến hành lắp đặt thử máy, đo áp suất gas, kiểm tra độ lạnh và hướng dẫn khách hàng sử dụng remote chi tiết.</li>
          </ol>
        </div>
      </div>
    </div>
  );
}

/* ==========================================================================
   Sub-view 3: Return Policy View
   ========================================================================== */
function ReturnPolicyView({ hotline }) {
  return (
    <div className="ac-policy-article">
      <div className="article-intro-box">
        <p>
          Nhằm mang lại sự an tâm tuyệt đối khi mua sắm máy lạnh tại <strong>MayLanhGiaKho</strong>, chúng tôi áp dụng chính sách
          đổi trả sản phẩm cực kỳ linh hoạt và minh bạch. Trong vòng <strong>30 đến 35 ngày</strong>, nếu máy gặp lỗi từ nhà sản xuất,
          Quý khách được đổi ngay sản phẩm mới 100%.
        </p>
      </div>

      {/* Section 1: 30-Day Replacement */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">1</span> Chính Sách Đổi Mới Sản Phẩm Lỗi Trong 30 - 35 Ngày
        </h3>
        <div className="two-cards-grid">
          <div className="spec-card">
            <span className="spec-icon">🔄</span>
            <h4>Đổi Cùng Model (1 Đổi 1)</h4>
            <p>
              Nếu máy phát sinh lỗi kỹ thuật do nhà sản xuất (như hỏng Block, lỗi bo mạch chủ, rò rỉ dàn lạnh từ nhà máy),
              MayLanhGiaKho sẽ đổi mới ngay một máy mới 100% cùng model hoàn toàn miễn phí.
            </p>
          </div>

          <div className="spec-card">
            <span className="spec-icon">✨</span>
            <h4>Đổi Sang Model Khác</h4>
            <p>
              Quý khách có thể nâng cấp sang model khác có công suất hoặc tính năng cao hơn. Giá trị sản phẩm mới bằng hoặc
              lớn hơn sản phẩm cũ, Quý khách chỉ cần bù thêm khoản chênh lệch giá niêm yết tại thời điểm đổi.
            </p>
          </div>
        </div>
      </div>

      {/* Section 2: Product Inspection Matrix Table */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">2</span> Tiêu Chuẩn Tiếp Nhận Đổi Trả Theo Ngành Hàng
        </h3>
        <p>Bảng phân loại điều kiện ngoại quan khi tiếp nhận đổi trả sản phẩm lỗi kỹ thuật:</p>
        <div className="table-responsive-wrapper">
          <table className="ac-policy-table">
            <thead>
              <tr>
                <th>Ngành Hàng</th>
                <th>Tình Trạng Vỏ Thùng</th>
                <th>Trầy Xước Ngoại Quan</th>
                <th>Móp Méo / Bể Vỡ</th>
                <th>Xử Lý</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Điện Lạnh</strong> (Máy lạnh, Tủ lạnh)</td>
                <td><span className="badge-ok">Chấp nhận mất thùng</span></td>
                <td><span className="badge-no">Không trầy xước nặng</span></td>
                <td><span className="badge-no">Không móp méo / bể</span></td>
                <td><strong className="text-primary">Đổi mới trong 24H</strong></td>
              </tr>
              <tr>
                <td><strong>Gia Dụng</strong> (Quạt làm mát, máy lọc)</td>
                <td><span className="badge-ok">Chấp nhận mất thùng</span></td>
                <td><span className="badge-no">Không trầy xước</span></td>
                <td><span className="badge-no">Không móp bể</span></td>
                <td><strong className="text-primary">Đổi mới trong 24H</strong></td>
              </tr>
              <tr>
                <td><strong>Tivi / Màn Hình</strong></td>
                <td><span className="badge-no">Bắt buộc nguyên thùng</span></td>
                <td><span className="badge-no">Không trầy xước</span></td>
                <td><span className="badge-no">Không nứt bể panel</span></td>
                <td><strong className="text-primary">Theo quy định hãng</strong></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      {/* Section 3: Non-defective Returns */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">3</span> Trường Hợp Đổi Trả Theo Nhu Cầu (Sản Phẩm Không Lỗi)
        </h3>
        <p>
          Trong trường hợp sản phẩm không có lỗi kỹ thuật nhưng khách hàng muốn thay đổi nhu cầu sử dụng, chúng tôi hỗ trợ
          thu hồi với mức phí khấu hao hợp lý:
        </p>
        <ul className="styled-bullet-list">
          <li><strong>Trong 10 ngày đầu tiên kể từ ngày mua:</strong> Khấu trừ <strong>30%</strong> giá trị hóa đơn máy.</li>
          <li><strong>Từ ngày thứ 11 đến ngày thứ 30:</strong> Khấu trừ <strong>45%</strong> giá trị hóa đơn máy.</li>
          <li><strong>Sau 30 ngày:</strong> Không áp dụng chính sách đổi trả theo nhu cầu cá nhân.</li>
          <li>
            <strong>Điều kiện bắt buộc:</strong> Máy phải còn nguyên vẹn 100%, chưa qua sửa chữa hoặc tự ý tháo mở,
            đầy đủ hóa đơn mua hàng, phiếu bảo hành và toàn bộ phụ kiện đi kèm (remote, sách hướng dẫn).
          </li>
        </ul>
      </div>

      {/* Section 4: Contact Support */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">4</span> Thủ Tục & Địa Điểm Đổi Trả
        </h3>
        <p>
          Quý khách có thể mang sản phẩm trực tiếp đến kho của chúng tôi tại: <strong>582 An Dương Vương, Bình Phú, TP. Hồ Chí Minh</strong>
          hoặc liên hệ hotline <a href={`tel:${hotline}`}>{hotline}</a> để kỹ thuật viên xuống kiểm tra biên bản lỗi tại nhà.
        </p>
      </div>
    </div>
  );
}

/* ==========================================================================
   Sub-view 4: Privacy Policy View
   ========================================================================== */
function PrivacyPolicyView({ email, hotline }) {
  return (
    <div className="ac-policy-article">
      <div className="article-intro-box">
        <p>
          <strong>MayLanhGiaKho (Công ty Điện Máy Phan Hòa)</strong> cam kết bảo vệ tối đa quyền riêng tư và dữ liệu cá nhân
          của Quý khách hàng. Chính sách này được ban hành nhằm đảm bảo sự minh bạch trong việc thu thập, lưu trữ, sử dụng
          và bảo vệ thông tin theo đúng các quy định pháp luật hiện hành của Việt Nam (Nghị định số 13/2023/NĐ-CP).
        </p>
      </div>

      {/* Section 1: Purpose */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">1</span> Mục Đích Thu Thập Thông Tin Khách Hàng
        </h3>
        <ul className="styled-check-list">
          <li><strong>Xử lý đơn hàng:</strong> Xác nhận đơn đặt hàng, xuất hóa đơn VAT điện tử, liên hệ hẹn lịch giao hàng và lắp đặt chính xác.</li>
          <li><strong>Kích hoạt bảo hành:</strong> Đăng ký kích hoạt bảo hành điện tử chính hãng trực tiếp từ hệ thống Daikin, Panasonic, Casper, Toshiba...</li>
          <li><strong>Hỗ trợ kỹ thuật:</strong> Tra cứu lịch sử mua máy, lịch bảo dưỡng, lịch nạp gas để hỗ trợ khách hàng nhanh chóng khi có sự cố.</li>
          <li><strong>Cải thiện dịch vụ:</strong> Khảo sát mức độ hài lòng của khách hàng để không ngừng nâng cao chất lượng dịch vụ kho và đội ngũ thợ.</li>
          <li><strong>Thông báo ưu đãi đặc quyền:</strong> Gửi thông tin khuyến mãi giá sỉ, voucher vệ sinh máy lạnh định kỳ (khi khách hàng đồng ý nhận tin).</li>
        </ul>
      </div>

      {/* Section 2: Data Types */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">2</span> Các Dữ Liệu Được Thu Thập
        </h3>
        <ul className="styled-bullet-list">
          <li>Họ và tên của người mua hàng hoặc đại diện công trình.</li>
          <li>Số điện thoại liên lạc chính và số Zalo hỗ trợ.</li>
          <li>Địa chỉ giao hàng và địa chỉ lắp ráp máy lạnh.</li>
          <li>Địa chỉ email nhận hóa đơn điện tử và xác nhận đơn hàng.</li>
          <li>Thông tin model sản phẩm, số serial máy, ngày mua và thời hạn bảo hành.</li>
          <li>
            <em>Lưu ý an toàn:</em> MayLanhGiaKho <strong>tuyệt đối không</strong> lưu trữ thông tin thẻ tín dụng/CVV hoặc mật khẩu ngân hàng của Quý khách.
            Mọi thanh toán điện tử đều qua cổng trung gian tài chính được cấp phép.
          </li>
        </ul>
      </div>

      {/* Section 3: Technical Security */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">3</span> Biện Pháp An Toàn & Bảo Mật Kỹ Thuật
        </h3>
        <div className="notice-box info">
          <ul className="styled-check-list">
            <li>Toàn bộ đường truyền kết nối trên website đều được mã hóa bằng chứng chỉ bảo mật tiêu chuẩn <strong>SSL/TLS 256-bit</strong>.</li>
            <li>Hệ thống máy chủ dữ liệu được bảo vệ bằng tường lửa nhiều lớp (Multi-layer Firewall) và chống tấn công từ chối dịch vụ.</li>
            <li>Chỉ những nhân sự có thẩm quyền trực tiếp (phòng Điều phối, phòng Kế toán và Chăm sóc khách hàng) mới được cấp quyền truy cập xử lý đơn hàng.</li>
            <li>Hệ thống tự động sao lưu dữ liệu dự phòng định kỳ hàng tuần.</li>
          </ul>
        </div>
      </div>

      {/* Section 4: Non-Disclosure */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">4</span> Cam Kết Không Chia Sẻ Dữ Liệu Cho Bên Thứ Ba
        </h3>
        <p>
          MayLanhGiaKho cam kết <strong>không bao giờ bán, cho thuê hoặc chia sẻ</strong> thông tin khách hàng cho bất kỳ bên thứ ba
          nào vì mục đích quảng cáo rác. Dữ liệu chỉ được chia sẻ trong các trường hợp bắt buộc sau:
        </p>
        <ul className="styled-bullet-list">
          <li>Cung cấp cho hãng sản xuất máy lạnh (Daikin, Panasonic, Toshiba...) để kích hoạt bảo hành điện tử chính hãng tận nhà.</li>
          <li>Cung cấp cho đơn vị đối tác vận chuyển hỏa tốc để thực hiện việc giao máy.</li>
          <li>Khi có yêu cầu bằng văn bản hợp pháp từ các cơ quan chức năng nhà nước theo luật định.</li>
        </ul>
      </div>

      {/* Section 5: Customer Rights */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">5</span> Quyền Lợi Của Khách Hàng Đối Với Dữ Liệu
        </h3>
        <p>
          Quý khách có toàn quyền yêu cầu kiểm tra, cập nhật hoặc xóa thông tin cá nhân của mình khỏi cơ sở dữ liệu của chúng tôi
          bất kỳ lúc nào bằng cách gửi yêu cầu tới email <a href={`mailto:${email}`}>{email}</a> hoặc liên hệ hotline <a href={`tel:${hotline}`}>{hotline}</a>.
        </p>
      </div>
    </div>
  );
}

/* ==========================================================================
   Sub-view 5: Recruitment Policy View
   ========================================================================== */
function RecruitmentPolicyView({ address, hotline, recruitmentHotline, onOpenApplyModal }) {
  const JOBS = [
    {
      id: 'ke-toan',
      title: 'Nhân Viên Kế Toán Bán Hàng & Kho',
      count: '2 Người',
      salary: '8.000.000đ - 12.000.000đ + Thưởng',
      experience: 'Kinh nghiệm từ 1 năm',
      type: 'Toàn thời gian (Giờ hành chính)',
      requirements: [
        'Tốt nghiệp Trung cấp/Cao đẳng trở lên chuyên ngành Kế toán, Tài chính hoặc Quản trị kinh doanh.',
        'Có kinh nghiệm làm kế toán bán hàng, kế toán kho thiết bị điện máy là lợi thế lớn.',
        'Sử dụng thành thạo Excel và các phần mềm bán hàng/kế toán thông dụng.',
        'Trung thực, cẩn thận, có trách nhiệm và kỹ năng xử lý chứng từ hóa đơn nhanh nhạy.',
      ],
      duties: [
        'Theo dõi, ghi nhận các đơn đặt hàng xuất nhập tại kho máy lạnh hàng ngày.',
        'Lập phiếu xuất kho, theo dõi công nợ khách hàng và đối chiếu công nợ nhà phân phối.',
        'Hỗ trợ xuất hóa đơn VAT điện tử cho khách hàng và công trình.',
        'Báo cáo tổng kết doanh thu và tồn kho định kỳ cho Ban Giám đốc.',
      ],
    },
    {
      id: 'tho-lap-dat',
      title: 'Kỹ Thuật Viên Lắp Đặt & Sửa Chữa Máy Lạnh',
      count: '3 Người',
      salary: '12.000.000đ - 20.000.000đ + Phụ Cấp + Tip',
      experience: 'Kinh nghiệm từ 1 năm trở lên',
      type: 'Toàn thời gian (Linh hoạt theo tuyến công trình)',
      requirements: [
        'Có tay nghề, am hiểu nguyên lý hoạt động của máy lạnh treo tường, âm trần, tủ đứng.',
        'Biết hàn ống đồng, hút chân không, nạp gas R32/R410A đúng kỹ thuật.',
        'Sức khỏe tốt, chịu khó, có xe máy đi lại, không ngại di chuyển trong khu vực TP.HCM.',
        'Ưu tiên ứng viên có chứng chỉ nghề điện lạnh hoặc bằng trung cấp cơ điện tử.',
      ],
      duties: [
        'Lắp đặt mới các dòng máy lạnh dân dụng và thương mại theo điều phối hàng ngày.',
        'Thực hiện dịch vụ bảo dưỡng, vệ sinh xịt rửa máy lạnh và nạp gas cho khách hàng.',
        'Kiểm tra chẩn đoán lỗi, xử lý rò rỉ nước, xì gas, lỗi bo mạch cơ bản.',
        'Hướng dẫn khách hàng sử dụng remote và bảo quản máy sau khi lắp đặt xong.',
      ],
    },
    {
      id: 'giao-hang',
      title: 'Nhân Viên Giao Nhận & Vận Chuyển Điện Máy',
      count: '2 Người',
      salary: '9.000.000đ - 14.000.000đ + Thưởng đơn',
      experience: 'Không yêu cầu (Sẽ được hướng dẫn)',
      type: 'Toàn thời gian',
      requirements: [
        'Nam từ 18 - 40 tuổi, có sức khỏe tốt, nhanh nhẹn, trung thực.',
        'Có bằng lái xe máy/xe ba gác hoặc bằng B2 (nếu lái xe tải nhỏ của công ty).',
        'Rành đường phố TP. Hồ Chí Minh và các khu vực lân cận.',
        'Cẩn thận khi bốc dỡ hàng hóa, có tinh thần trách nhiệm cao.',
      ],
      duties: [
        'Nhận hàng máy lạnh nguyên thùng tại kho 582 An Dương Vương, Bình Phú, TP.HCM.',
        'Vận chuyển an toàn đến địa chỉ nhà ở/công trình của khách hàng theo tuyến được phân công.',
        'Hỗ trợ phụ kỹ thuật viên bốc vác máy lên vị trí lắp đặt nếu cần.',
        'Thu tiền COD hoặc xác nhận biên bản giao nhận với khách hàng.',
      ],
    },
    {
      id: 'dieu-phoi',
      title: 'Nhân Viên Điều Phối Đơn Hàng & Thợ Lắp',
      count: '1 Người',
      salary: '9.000.000đ - 13.000.000đ + Thưởng KPI',
      experience: 'Kinh nghiệm từ 1 năm điều phối/CSKH',
      type: 'Toàn thời gian',
      requirements: [
        'Khả năng giao tiếp tốt, giọng nói dễ nghe, bình tĩnh xử lý tình huống phát sinh.',
        'Có tư duy sắp xếp tuyến đường thông minh, tối ưu hóa thời gian di chuyển của đội xe.',
        'Nhiệt tình, chủ động, chịu được áp lực trong các đợt cao điểm mùa nóng.',
      ],
      duties: [
        'Tiếp nhận thông tin đơn hàng mới từ phòng kinh doanh và website.',
        'Phân bổ lịch giao hàng và thợ lắp đặt cho từng khu vực quận huyện một cách hợp lý nhất.',
        'Theo dõi tiến độ di chuyển của thợ và cập nhật trạng thái đơn hàng cho khách hàng.',
        'Giải quyết các phát sinh về giờ giấc giao nhận hoặc vật tư công trình.',
      ],
    },
  ];

  return (
    <div className="ac-policy-article">
      <div className="article-intro-box highlight-orange">
        <p>
          Do nhu cầu mở rộng quy mô tổng kho phân phối và đáp ứng lượng đơn hàng tăng cao trong mùa cao điểm,{' '}
          <strong>Điện Máy Phan Hòa (MayLanhGiaKho)</strong> trân trọng thông báo tuyển dụng các vị trí nhân sự
          năng động, nhiệt huyết với mức thu nhập cạnh tranh, môi trường làm việc thân thiện và cơ hội phát triển bền vững!
        </p>
      </div>

      {/* Workplace details */}
      <div className="recruitment-meta-strip">
        <div className="rm-item">
          <span className="rm-icon">🏢</span>
          <div>
            <strong>Địa điểm làm việc:</strong>
            <p>{address}</p>
          </div>
        </div>
        <div className="rm-item">
          <span className="rm-icon">📞</span>
          <div>
            <strong>Hotline nộp hồ sơ:</strong>
            <p><a href={`tel:${hotline.replace(/\s+/g, '')}`}>{hotline}</a> - <a href={`tel:${recruitmentHotline.replace(/\s+/g, '')}`}>{recruitmentHotline}</a></p>
          </div>
        </div>
        <div className="rm-item">
          <span className="rm-icon">⏰</span>
          <div>
            <strong>Thời gian phỏng vấn:</strong>
            <p>Phỏng vấn trực tiếp từ 8:30 - 17:00 các ngày trong tuần</p>
          </div>
        </div>
      </div>

      {/* General Benefits */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">1</span> Quyền Lợi & Chế Độ Đãi Ngộ Dành Cho Nhân Viên
        </h3>
        <div className="benefits-grid">
          <div className="b-card">
            <span className="b-icon">💰</span>
            <h4>Thu Nhập Hấp Dẫn</h4>
            <p>Lương cứng cạnh tranh + Thưởng doanh thu + Phụ cấp chuyên cần + Tip công trình.</p>
          </div>
          <div className="b-card">
            <span className="b-icon">🎁</span>
            <h4>Thưởng Lễ Tết & Tháng 13</h4>
            <p>Lương tháng 13 đầy đủ, quà tặng và thưởng nóng các dịp Lễ, Tết trong năm.</p>
          </div>
          <div className="b-card">
            <span className="b-icon">🏥</span>
            <h4>Bảo Hiểm Đầy Đủ</h4>
            <p>Tham gia BHXH, BHYT, BHTN và bảo hiểm tai nạn lao động theo quy định pháp luật.</p>
          </div>
          <div className="b-card">
            <span className="b-icon">🛠️</span>
            <h4>Trang Thiết Bị Miễn Phí</h4>
            <p>Cấp phát đồng phục, máy móc đồ nghề cao cấp, hỗ trợ tiền xăng xe điện thoại.</p>
          </div>
        </div>
      </div>

      {/* Available Positions Job Cards */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">2</span> Các Vị Trí Đang Tuyển Dụng ({JOBS.length} Vị Trí)
        </h3>
        <div className="job-cards-list">
          {JOBS.map((job) => (
            <div key={job.id} className="ac-job-card">
              <div className="job-card-header">
                <div>
                  <h4 className="job-title">{job.title}</h4>
                  <div className="job-tags">
                    <span className="tag-count">Số lượng: {job.count}</span>
                    <span className="tag-exp">{job.experience}</span>
                    <span className="tag-type">{job.type}</span>
                  </div>
                </div>
                <div className="job-salary-wrap">
                  <span className="salary-label">Mức lương:</span>
                  <span className="salary-val">{job.salary}</span>
                </div>
              </div>

              <div className="job-card-body">
                <div className="job-column">
                  <h5>📌 Yêu Cầu Công Việc:</h5>
                  <ul>
                    {job.requirements.map((req, i) => (
                      <li key={i}>{req}</li>
                    ))}
                  </ul>
                </div>

                <div className="job-column">
                  <h5>📝 Mô Tả Nhiệm Vụ:</h5>
                  <ul>
                    {job.duties.map((duty, i) => (
                      <li key={i}>{duty}</li>
                    ))}
                  </ul>
                </div>
              </div>

              <div className="job-card-footer">
                <div className="job-urgent-badge">🔥 Tuyển dụng đi làm ngay</div>
                <div className="job-actions">
                  <a
                    href={`tel:${hotline.replace(/\s+/g, '')}`}
                    className="btn-job-call"
                  >
                    📞 Gọi Ứng Tuyển
                  </a>
                  <button
                    type="button"
                    className="btn-job-apply"
                    onClick={() => onOpenApplyModal(job.title)}
                  >
                    Nộp Hồ Sơ Nhanh
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* How to Apply Section */}
      <div className="ac-policy-section">
        <h3 className="section-title">
          <span className="st-num">3</span> Hình Thức Nộp Hồ Sơ
        </h3>
        <div className="notice-box info">
          <p><strong>Ứng viên có thể ứng tuyển qua 3 cách thuận tiện nhất:</strong></p>
          <ol>
            <li><strong>Cách 1: Nộp trực tiếp tại văn phòng kho:</strong> Đến địa chỉ <em>{address}</em>, gặp phòng Nhân sự (mang theo CCCD và sơ yếu lý lịch cơ bản).</li>
            <li><strong>Cách 2: Gọi điện thoại trực tiếp:</strong> Gọi số Hotline Nhân sự: <a href={`tel:${hotline.replace(/\s+/g, '')}`}>{hotline}</a> hoặc <a href={`tel:${recruitmentHotline.replace(/\s+/g, '')}`}>{recruitmentHotline}</a> để hẹn lịch phỏng vấn.</li>
            <li><strong>Cách 3: Ứng tuyển nhanh qua Zalo:</strong> Nhắn tin Zalo số <strong>0583 593 999</strong> kèm thông tin vị trí ứng tuyển.</li>
          </ol>
          <p style={{ marginTop: '10px', fontStyle: 'italic', color: '#0369a1' }}>
            🎉 Chào đón các bạn gia nhập đại gia đình Điện Máy Phan Hòa để cùng phát triển vững mạnh!
          </p>
        </div>
      </div>
    </div>
  );
}
