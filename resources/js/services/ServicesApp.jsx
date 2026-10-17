import React, { useState, useMemo } from 'react';

export default function ServicesApp({ initialData = {} }) {
  const rawServices = initialData.dichvus || [];
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategory, setSelectedCategory] = useState('all');

  // Format date helper
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

  // Resolve image URL
  const resolveImage = (img) => {
    if (!img) return '/template/images/icons/iconml.png';
    if (img.startsWith('http://') || img.startsWith('https://')) return img;
    if (img.startsWith('/')) return img;
    return `/${img}`;
  };

  // Core Service Packages for AC Customers
  const corePackages = [
    {
      id: 'lap-dat',
      title: 'Lắp Đặt Máy Lạnh Chuyên Nghiệp',
      category: 'lapdat',
      icon: '🔧',
      desc: 'Lắp đặt máy lạnh treo tường, âm trần, tủ đứng đúng tiêu chuẩn kỹ thuật nhà sản xuất. Hút chân không máy Inverter miễn phí.',
      features: ['Miễn phí khảo sát vị trí lắp đặt', 'Bảo hành lắp đặt 12 tháng', 'Ống đồng Thái Lan chuẩn 0.7 - 0.8mm', 'Bàn giao sạch sẽ, đúng tiến độ'],
      priceNote: 'Từ 350.000đ / bộ',
      badge: 'Phổ biến nhất',
      hotline: '0583593999',
    },
    {
      id: 've-sinh',
      title: 'Bảo Trì - Vệ Sinh Máy Lạnh Định Kỳ',
      category: 'vesinh',
      icon: '❄️',
      desc: 'Xịt rửa dàn nóng, dàn lạnh bằng máy bơm tăng áp. Diệt khuẩn khử mùi nấm mốc, thông tắc đường ống nước thải và cân chỉnh gas.',
      features: ['Tăng hiệu suất làm lạnh sâu', 'Tiết kiệm 20% - 30% điện năng', 'Giảm thiểu vi khuẩn, bảo vệ sức khỏe', 'Cân chỉnh kiểm tra áp suất gas miễn phí'],
      priceNote: 'Từ 180.000đ / máy',
      badge: 'Khuyên dùng định kỳ',
      hotline: '0583593999',
    },
    {
      id: 'nap-gas',
      title: 'Nạp Gas Bổ Sung & Xử Lý Xì Gas',
      category: 'suachua',
      icon: '⚡',
      desc: 'Nạp đầy đủ các loại gas R32, R410A, R22 nhập khẩu chuẩn độ tinh khiết. Kiểm tra áp suất, hàn ống đồng và thử kín bằng máy đo chuyên dụng.',
      features: ['Gas chính hãng Ấn Độ / USA', 'Đo dòng ampe và áp suất chuẩn', 'Kiểm tra kỹ các đầu tán, mối hàn', 'Bảo hành không tái xì rò rỉ'],
      priceNote: 'Từ 350.000đ / lần',
      badge: 'Gas chuẩn hãng',
      hotline: '0583593999',
    },
    {
      id: 'sua-chua',
      title: 'Sửa Chữa Máy Lạnh & Thay Linh Kiện',
      category: 'suachua',
      icon: '🛠️',
      desc: 'Khắc phục triệt để máy không lạnh, chảy nước dàn lạnh, chớp đèn báo lỗi bo mạch, block kêu to, quạt dàn nóng không chạy.',
      features: ['Chẩn đoán đúng bệnh, báo đúng giá', 'Linh kiện thay thế mới 100% chính hãng', 'Có mặt nhanh sau 30 phút đặt hẹn', 'Phiếu bảo hành linh kiện 6 - 12 tháng'],
      priceNote: 'Báo giá minh bạch trước khi làm',
      badge: 'Có mặt sau 30p',
      hotline: '0583593999',
    },
    {
      id: 'ong-am-tuong',
      title: 'Thi Công Ống Đồng Âm Tường Dự Án',
      category: 'lapdat',
      icon: '🏢',
      desc: 'Thi công đường ống đồng chôn tường cho nhà phố, biệt thự, căn hộ chung cư đang xây thô. Đảm bảo thẩm mỹ và an toàn tuyệt đối.',
      features: ['Ống đồng bọc bảo ôn đôi cách nhiệt', 'Nén khí Nitơ test áp lực trước khi tô trát', 'Đi kèm dây điện Daphaco và ống thoát nước', 'Bản vẽ sơ đồ ống rõ ràng cho gia chủ'],
      priceNote: 'Đo thực tế theo mét',
      badge: 'Chuẩn công trình',
      hotline: '0583593999',
    },
    {
      id: 'thu-mua',
      title: 'Thu Mua & Đổi Máy Lạnh Cũ Lấy Mới',
      category: 'thumua',
      icon: '🔄',
      desc: 'Thu mua máy lạnh cũ giá cao tận nhà. Hỗ trợ khách hàng nâng cấp lên dòng máy lạnh Inverter tiết kiệm điện thế hệ mới với chi phí bù tốt nhất.',
      features: ['Định giá nhanh qua Zalo / điện thoại', 'Tháo dỡ nhanh gọn, tự vận chuyển', 'Thanh toán tiền mặt hoặc chuyển khoản ngay', 'Trợ giá lên đến 2.000.000đ khi đổi máy'],
      priceNote: 'Giá thu mua cao nhất thị trường',
      badge: 'Trợ giá đổi mới',
      hotline: '0583593999',
    },
  ];

  // Filter dynamic services from DB
  const filteredDbServices = useMemo(() => {
    return rawServices.filter((s) => {
      const matchSearch =
        !searchTerm ||
        (s.name && s.name.toLowerCase().includes(searchTerm.toLowerCase())) ||
        (s.description && s.description.toLowerCase().includes(searchTerm.toLowerCase()));
      return matchSearch;
    });
  }, [rawServices, searchTerm]);

  // Filter core packages
  const filteredCorePackages = useMemo(() => {
    return corePackages.filter((pkg) => {
      const matchCategory = selectedCategory === 'all' || pkg.category === selectedCategory;
      const matchSearch =
        !searchTerm ||
        pkg.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
        pkg.desc.toLowerCase().includes(searchTerm.toLowerCase());
      return matchCategory && matchSearch;
    });
  }, [selectedCategory, searchTerm]);

  return (
    <div className="ac-app ac-services-page">
      {/* Breadcrumb */}
      <div className="ac-breadcrumb-wrap">
        <div className="ac-container">
          <ul className="ac-breadcrumb">
            <li className="active">Dịch vụ máy lạnh</li>
          </ul>
        </div>
      </div>

      <div className="ac-container">
        {/* Hero Section */}
        <div className="ac-services-hero">
          <div className="ac-services-hero-content">
            <span className="ac-services-tag">⚡ Dịch Vụ Máy Lạnh Tận Nơi Toàn TP.HCM</span>
            <h1 className="ac-services-title">
              Dịch Vụ Lắp Đặt, Vệ Sinh & Sửa Chữa Máy Lạnh Chuyên Nghiệp
            </h1>
            <p className="ac-services-desc">
              <strong>Máy Lạnh Giá Kho</strong> cung cấp giải pháp điện lạnh toàn diện cho gia đình, văn phòng và công trình. 
              Đội ngũ kỹ thuật viên tay nghề cao được đào tạo bài bản từ Daikin, Panasonic, Casper, cam kết có mặt sau 30 phút, 
              báo giá minh bạch, bảo hành dài hạn.
            </p>
            <div className="ac-hero-cta-group">
              <a href="tel:0583593999" className="ac-btn-hotline-pulse">
                <span className="ac-pulse-icon">📞</span>
                <span>
                  <small>Tổng đài đặt lịch 24/7</small>
                  <strong>0583 593 999</strong>
                </span>
              </a>
              <a href="https://zalo.me/0583593999" target="_blank" rel="noopener noreferrer" className="ac-btn-zalo-hero">
                <span className="ac-zalo-badge">Zalo</span>
                <span>Chat báo giá ngay</span>
              </a>
              <a href="/banggia" className="ac-btn-banggia-link">
                <span>Xem bảng giá công khai</span>
                <span className="ac-arrow">→</span>
              </a>
            </div>
          </div>
        </div>

        {/* 4 Guarantees */}
        <div className="ac-services-guarantees">
          <div className="ac-guarantee-card">
            <div className="ac-guarantee-icon">⚡</div>
            <div className="ac-guarantee-info">
              <h4>Có Mặt Sau 30 Phút</h4>
              <p>Phục vụ hỏa tốc tại tất cả các quận huyện TP.HCM và vùng phụ cận.</p>
            </div>
          </div>
          <div className="ac-guarantee-card">
            <div className="ac-guarantee-icon">🛡️</div>
            <div className="ac-guarantee-info">
              <h4>Bảo Hành 6 - 12 Tháng</h4>
              <p>Cam kết bảo hành nghiêm túc, dán tem và xuất phiếu nghiệm thu rõ ràng.</p>
            </div>
          </div>
          <div className="ac-guarantee-card">
            <div className="ac-guarantee-icon">💰</div>
            <div className="ac-guarantee-info">
              <h4>Báo Giá Minh Bạch</h4>
              <p>Kiểm tra kỹ lưỡng, báo đúng giá niêm yết trước khi làm, không phát sinh phụ phí.</p>
            </div>
          </div>
          <div className="ac-guarantee-card">
            <div className="ac-guarantee-icon">👨‍🔧</div>
            <div className="ac-guarantee-info">
              <h4>Thợ Giỏi 10+ Năm</h4>
              <p>Thao tác sạch sẽ, chuẩn kỹ thuật, máy hút chân không chuyên dụng cho Inverter.</p>
            </div>
          </div>
        </div>

        {/* Search & Filter Toolbar */}
        <div className="ac-services-toolbar">
          <div className="ac-services-filter-tabs">
            <button
              type="button"
              className={`ac-svc-tab ${selectedCategory === 'all' ? 'active' : ''}`}
              onClick={() => setSelectedCategory('all')}
            >
              Tất cả dịch vụ
            </button>
            <button
              type="button"
              className={`ac-svc-tab ${selectedCategory === 'vesinh' ? 'active' : ''}`}
              onClick={() => setSelectedCategory('vesinh')}
            >
              Vệ sinh - Bảo trì
            </button>
            <button
              type="button"
              className={`ac-svc-tab ${selectedCategory === 'lapdat' ? 'active' : ''}`}
              onClick={() => setSelectedCategory('lapdat')}
            >
              Lắp đặt & Di dời
            </button>
            <button
              type="button"
              className={`ac-svc-tab ${selectedCategory === 'suachua' ? 'active' : ''}`}
              onClick={() => setSelectedCategory('suachua')}
            >
              Sửa chữa & Nạp gas
            </button>
            <button
              type="button"
              className={`ac-svc-tab ${selectedCategory === 'thumua' ? 'active' : ''}`}
              onClick={() => setSelectedCategory('thumua')}
            >
              Đổi máy cũ lấy mới
            </button>
          </div>

          <div className="ac-services-search">
            {/* <span className="ac-search-icon">🔍</span> */}
            <input
              type="text"
              placeholder="Tìm nhanh: vệ sinh, lắp đặt, nạp gas, ống đồng..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
            />
            {searchTerm && (
              <button type="button" className="ac-search-clear" onClick={() => setSearchTerm('')}>
                ✕
              </button>
            )}
          </div>
        </div>

        {/* Database Articles / Services if present */}
        {filteredDbServices.length > 0 && (
          <div className="ac-db-services-section">
            <div className="ac-section-header">
              <h2 className="ac-section-title">
                <span className="ac-title-accent"></span> Bài Viết Dịch Vụ Nổi Bật
              </h2>
              <span className="ac-section-subtitle">Hướng dẫn chi tiết quy trình và chính sách dịch vụ tại MayLanhGiaKho</span>
            </div>

            <div className="ac-db-services-grid">
              {filteredDbServices.map((item) => (
                <div key={item.id} className="ac-db-svc-card">
                  <a href={`/dichvu-detail/${item.slug}`} className="ac-db-svc-image-wrap">
                    <img src={resolveImage(item.image)} alt={item.name} loading="lazy" />
                    <span className="ac-db-svc-badge">Dịch vụ chính hãng</span>
                  </a>
                  <div className="ac-db-svc-body">
                    <div className="ac-db-svc-meta">
                      <span>📅 {formatDate(item.created_at)}</span>
                      <span>📍 Toàn TP.HCM</span>
                    </div>
                    <h3 className="ac-db-svc-title">
                      <a href={`/dichvu-detail/${item.slug}`}>{item.name}</a>
                    </h3>
                    <p className="ac-db-svc-desc">
                      {item.description ? item.description.slice(0, 140) + '...' : 'Dịch vụ điện lạnh chất lượng cao tại Máy Lạnh Giá Kho...'}
                    </p>
                    <div className="ac-db-svc-actions">
                      <a href={`/dichvu-detail/${item.slug}`} className="ac-btn-read-more">
                        Xem chi tiết <span>→</span>
                      </a>
                      <a href="tel:0583593999" className="ac-btn-call-quick">
                        Đặt thợ ngay
                      </a>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        )}

        {/* Core Comprehensive Service Packages */}
        <div className="ac-core-packages-section">
          <div className="ac-section-header">
            <h2 className="ac-section-title">
              <span className="ac-title-accent"></span> Các Gói Dịch Vụ Máy Lạnh Phổ Biến
            </h2>
            <p className="ac-section-subtitle">
              Đáp ứng đầy đủ mọi nhu cầu kỹ thuật điện lạnh từ gia đình nhỏ đến các hệ thống văn phòng lớn
            </p>
          </div>

          <div className="ac-core-packages-grid">
            {filteredCorePackages.map((pkg) => (
              <div key={pkg.id} className="ac-package-card">
                <div className="ac-pkg-header">
                  <div className="ac-pkg-icon">{pkg.icon}</div>
                  <div className="ac-pkg-badges">
                    <span className="ac-pkg-badge">{pkg.badge}</span>
                  </div>
                </div>

                <h3 className="ac-pkg-title">{pkg.title}</h3>
                <p className="ac-pkg-desc">{pkg.desc}</p>

                <div className="ac-pkg-features">
                  <ul>
                    {pkg.features.map((feat, idx) => (
                      <li key={idx}>
                        <span className="ac-check-icon">✓</span> {feat}
                      </li>
                    ))}
                  </ul>
                </div>

                <div className="ac-pkg-footer">
                  <div className="ac-pkg-price-wrap">
                    <span className="ac-price-label">Chi phí tham khảo</span>
                    <span className="ac-pkg-price">{pkg.priceNote}</span>
                  </div>
                  <div className="ac-pkg-btns">
                    <a href={`tel:${pkg.hotline}`} className="ac-pkg-call-btn">
                      <span>Gọi đặt lịch: {pkg.hotline}</span>
                    </a>
                    <a
                      href={`https://zalo.me/${pkg.hotline}?text=${encodeURIComponent('Tôi muốn tư vấn dịch vụ: ' + pkg.title)}`}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="ac-pkg-zalo-btn"
                    >
                      Chat Zalo
                    </a>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* 4-Step Professional Workflow */}
        <div className="ac-workflow-section">
          <div className="ac-section-header text-center">
            <h2 className="ac-section-title">Quy Trình Phục Vụ 4 Bước Chuẩn Kỹ Thuật</h2>
            <p className="ac-section-subtitle">
              Nhanh chóng - Chuyên nghiệp - Minh bạch - Đảm bảo quyền lợi tối đa cho khách hàng
            </p>
          </div>

          <div className="ac-workflow-steps">
            <div className="ac-step-item">
              <div className="ac-step-num">01</div>
              <div className="ac-step-content">
                <h4>Tiếp Nhận Thông Tin</h4>
                <p>Khách hàng gọi Hotline hoặc nhắn Zalo. Nhân viên tư vấn lắng nghe nhu cầu và đặt lịch hẹn linh hoạt.</p>
              </div>
            </div>
            <div className="ac-step-connector">→</div>
            <div className="ac-step-item">
              <div className="ac-step-num">02</div>
              <div className="ac-step-content">
                <h4>Khảo Sát & Báo Giá</h4>
                <p>Kỹ thuật viên đến tận nơi kiểm tra thực tế, tư vấn giải pháp tối ưu và báo giá theo bảng niêm yết.</p>
              </div>
            </div>
            <div className="ac-step-connector">→</div>
            <div className="ac-step-item">
              <div className="ac-step-num">03</div>
              <div className="ac-step-content">
                <h4>Tiến Hành Thi Công</h4>
                <p>Thực hiện lắp đặt, vệ sinh hoặc sửa chữa đúng kỹ thuật, an toàn, sử dụng dụng cụ và vật tư chuẩn hãng.</p>
              </div>
            </div>
            <div className="ac-step-connector">→</div>
            <div className="ac-step-item">
              <div className="ac-step-num">04</div>
              <div className="ac-step-content">
                <h4>Nghiệm Thu & Bảo Hành</h4>
                <p>Chạy thử máy lạnh làm mát ổn định, dọn dẹp hiện trường sạch sẽ, bàn giao phiếu bảo hành và thanh toán.</p>
              </div>
            </div>
          </div>
        </div>

        {/* Bottom Banner Call to Action */}
        <div className="ac-services-cta-banner">
          <div className="ac-cta-banner-content">
            <h3>Cần Đặt Lịch Hoặc Khảo Sát Báo Giá Máy Lạnh Ngay Hôm Nay?</h3>
            <p>
              Đừng ngần ngại liên hệ! Đội ngũ kỹ thuật viên của Máy Lạnh Giá Kho luôn túc trực hỗ trợ bạn mọi lúc, mọi nơi tại TP.HCM.
            </p>
          </div>
          <div className="ac-cta-banner-buttons">
            <a href="tel:0583593999" className="ac-cta-phone-btn">
              <span className="ac-btn-icon">📞</span> 0583 593 999
            </a>
            <a href="https://zalo.me/0583593999" target="_blank" rel="noopener noreferrer" className="ac-cta-zalo-btn">
              Chat Zalo Báo Giá
            </a>
            <a href="/contact" className="ac-cta-contact-btn">
              Gửi yêu cầu trực tuyến
            </a>
          </div>
        </div>
      </div>
    </div>
  );
}
