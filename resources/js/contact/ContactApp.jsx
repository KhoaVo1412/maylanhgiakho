import React, { useState, useEffect } from 'react';

export default function ContactApp({ initialData = {} }) {
  const csrfToken = initialData.csrf_token || '';
  const flashSuccess = initialData.flash_success || '';
  const flashError = initialData.flash_error || '';

  // Form State
  const [formData, setFormData] = useState({
    ten: '',
    diachi: '',
    dienthoai: '',
    email: '',
    tieude: 'Tư vấn mua máy lạnh giá sỉ',
    noidung: '',
  });

  const [formErrors, setFormErrors] = useState({});
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [submitStatus, setSubmitStatus] = useState(flashSuccess ? 'success' : flashError ? 'error' : null);
  const [statusMessage, setStatusMessage] = useState(flashSuccess || flashError || '');

  // Pre-fill from query string if available
  useEffect(() => {
    try {
      const params = new URLSearchParams(window.location.search);
      const note = params.get('note');
      if (note) {
        setFormData((prev) => ({
          ...prev,
          tieude: 'Yêu cầu dịch vụ',
          noidung: note,
        }));
      }
    } catch {
      // ignore
    }
  }, []);

  // Validate form
  const validateForm = () => {
    const errors = {};
    if (!formData.ten.trim()) errors.ten = 'Vui lòng nhập họ và tên của bạn';
    if (!formData.dienthoai.trim()) {
      errors.dienthoai = 'Vui lòng nhập số điện thoại';
    } else {
      const phoneClean = formData.dienthoai.replace(/\s+/g, '');
      if (!/(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/.test(phoneClean)) {
        errors.dienthoai = 'Số điện thoại không hợp lệ (cần 10 chữ số)';
      }
    }
    if (!formData.diachi.trim()) errors.diachi = 'Vui lòng nhập địa chỉ của bạn';
    if (!formData.noidung.trim()) errors.noidung = 'Vui lòng nhập nội dung liên hệ';

    setFormErrors(errors);
    return Object.keys(errors).length === 0;
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
    if (formErrors[name]) {
      setFormErrors((prev) => ({ ...prev, [name]: null }));
    }
  };

  const handleReset = () => {
    setFormData({
      ten: '',
      diachi: '',
      dienthoai: '',
      email: '',
      tieude: 'Tư vấn mua máy lạnh giá sỉ',
      noidung: '',
    });
    setFormErrors({});
  };

  const handleSubmit = (e) => {
    if (!validateForm()) {
      e.preventDefault();
      return;
    }
    setIsSubmitting(true);
    // Allow native POST form submission to /contactadd
  };

  const coveredDistricts = [
    'Quận 1', 'Quận 3', 'Quận 4', 'Quận 5', 'Quận 6', 'Quận 7', 'Quận 8',
    'Quận 10', 'Quận 11', 'Quận 12', 'Bình Tân', 'Tân Phú', 'Tân Bình',
    'Gò Vấp', 'Phú Nhuận', 'Bình Thạnh', 'TP. Thủ Đức', 'Bình Chánh',
    'Hóc Môn', 'Nhà Bè', 'Củ Chi', 'Bình Dương', 'Long An', 'Đồng Nai'
  ];

  return (
    <div className="ac-app ac-contact-page">
      {/* Breadcrumb */}
      <div className="ac-breadcrumb-wrap">
        <div className="ac-container">
          <ul className="ac-breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li>/</li>
            <li className="active">Liên hệ</li>
          </ul>
        </div>
      </div>

      <div className="ac-container">
        {/* Hero Section */}
        <div className="ac-contact-hero">
          <span className="ac-contact-hero-tag">📍 Tổng Kho & Trung Tâm Kỹ Thuật</span>
          <h1 className="ac-contact-hero-title">Liên Hệ Máy Lạnh Giá Kho</h1>
          <p className="ac-contact-hero-desc">
            Chúng tôi luôn sẵn sàng hỗ trợ quý khách hàng 24/7 về tư vấn chọn máy, báo giá sỉ cho công trình, 
            và dịch vụ lắp đặt, sửa chữa bảo trì nhanh trong 30 phút tại TP.HCM.
          </p>
        </div>

        {/* Status Alert if passed from server */}
        {submitStatus && (
          <div className={`ac-contact-alert ${submitStatus === 'success' ? 'success' : 'error'}`}>
            <span className="ac-alert-icon">{submitStatus === 'success' ? '✅' : '⚠️'}</span>
            <div className="ac-alert-content">
              <strong>{submitStatus === 'success' ? 'Gửi thành công!' : 'Có lỗi xảy ra'}</strong>
              <p>{statusMessage || (submitStatus === 'success' ? 'Chúng tôi đã nhận được thông tin và sẽ gọi lại cho quý khách trong ít phút!' : 'Vui lòng kiểm tra lại thông tin và thử lại.')}</p>
            </div>
            <button type="button" className="ac-alert-dismiss" onClick={() => setSubmitStatus(null)}>✕</button>
          </div>
        )}

        {/* 2-Column Layout */}
        <div className="ac-contact-main-grid">
          {/* Left Column: Contact Cards */}
          <div className="ac-contact-info-col">
            <div className="ac-contact-card primary">
              <div className="ac-card-header-line">
                <span className="ac-card-badge">Tổng Kho Phân Phối</span>
              </div>
              <h2 className="ac-company-name">CÔNG TY TNHH MÁY LẠNH GIÁ KHO</h2>
              <p className="ac-company-slogan">Phân phối máy lạnh chính hãng - Giá sỉ tận kho cho mọi nhà</p>

              <div className="ac-contact-details-list">
                <div className="ac-contact-detail-row">
                  <div className="ac-detail-icon">📍</div>
                  <div className="ac-detail-text">
                    <span className="ac-detail-label">Địa chỉ tổng kho & showroom:</span>
                    <strong className="ac-detail-val">582 An Dương Vương, Bình Phú, TP. Hồ Chí Minh</strong>
                    <a
                      href="https://maps.google.com/?q=582+An+Dương+Vương,+Phường+11,+Quận+6,+Thành+phố+Hồ+Chí+Minh"
                      target="_blank"
                      rel="noopener noreferrer"
                      className="ac-btn-maps-link"
                    >
                      Xem chỉ đường Google Maps ↗
                    </a>
                  </div>
                </div>

                <div className="ac-contact-detail-row">
                  <div className="ac-detail-icon">📞</div>
                  <div className="ac-detail-text">
                    <span className="ac-detail-label">Hotline tư vấn mua hàng & dự án:</span>
                    <a href="tel:0583593999" className="ac-hotline-link">
                      0583 593 999
                    </a>
                    <span className="ac-detail-label" style={{ marginTop: '6px' }}>Hotline kỹ thuật & sửa chữa:</span>
                    <a href="tel:0353353286" className="ac-hotline-link secondary">
                      0353 353 286
                    </a>
                  </div>
                </div>

                <div className="ac-contact-detail-row">
                  <div className="ac-detail-icon">💬</div>
                  <div className="ac-detail-text">
                    <span className="ac-detail-label">Zalo hỗ trợ trực tuyến:</span>
                    <div className="ac-zalo-links-wrap">
                      <a href="https://zalo.me/0583593999" target="_blank" rel="noopener noreferrer" className="ac-zalo-chip">
                        <span>Zalo:</span> <strong>0583 593 999</strong>
                      </a>
                      <a href="https://zalo.me/0353353286" target="_blank" rel="noopener noreferrer" className="ac-zalo-chip">
                        <span>Zalo:</span> <strong>0353 353 286</strong>
                      </a>
                    </div>
                  </div>
                </div>

                <div className="ac-contact-detail-row">
                  <div className="ac-detail-icon">✉️</div>
                  <div className="ac-detail-text">
                    <span className="ac-detail-label">Email liên hệ:</span>
                    <a href="mailto:phanvanhoa231102@gmail.com" className="ac-mail-link">
                      phanvanhoa231102@gmail.com
                    </a>
                  </div>
                </div>

                <div className="ac-contact-detail-row">
                  <div className="ac-detail-icon">⏰</div>
                  <div className="ac-detail-text">
                    <span className="ac-detail-label">Thời gian làm việc:</span>
                    <strong className="ac-detail-val">07:30 – 21:00</strong>
                    <small style={{ color: '#059669', fontWeight: 600 }}> (Thứ 2 – Chủ Nhật, mở cửa cả ngày lễ)</small>
                  </div>
                </div>
              </div>

              {/* Direct Quick Actions */}
              <div className="ac-direct-actions">
                <a href="tel:0583593999" className="ac-action-btn phone">
                  <span>📞</span> Gọi tư vấn ngay
                </a>
                <a href="https://zalo.me/0583593999" target="_blank" rel="noopener noreferrer" className="ac-action-btn zalo">
                  <span>💬</span> Nhắn Zalo
                </a>
              </div>
            </div>

            {/* Service Coverage Badges */}
            <div className="ac-coverage-card">
              <h4>🚀 Khu Vực Phục Vụ Hỏa Tốc (Sau 30 Phút):</h4>
              <p>Đội ngũ kỹ thuật viên túc trực tại tất cả các trạm kỹ thuật khu vực:</p>
              <div className="ac-district-chips">
                {coveredDistricts.map((d, i) => (
                  <span key={i} className="ac-district-chip">{d}</span>
                ))}
              </div>
            </div>
          </div>

          {/* Right Column: Contact Form */}
          <div className="ac-contact-form-col">
            <div className="ac-form-card">
              <div className="ac-form-header">
                <h3>Gửi Yêu Cầu Liên Hệ & Báo Giá</h3>
                <p>
                  Quý khách vui lòng điền các thông tin dưới đây. 
                  Nhân viên chăm sóc khách hàng của MayLanhGiaKho sẽ liên hệ lại ngay trong vòng 5 - 10 phút.
                </p>
              </div>

              <form action="/contactadd" method="POST" onSubmit={handleSubmit} className="ac-styled-contact-form">
                <input type="hidden" name="_token" value={csrfToken} />

                <div className="ac-form-grid-2">
                  <div className={`ac-form-group ${formErrors.ten ? 'has-error' : ''}`}>
                    <label htmlFor="input_ten">
                      Họ và tên <span className="req">*</span>
                    </label>
                    <div className="ac-input-wrapper">
                      <span className="ac-input-icon">👤</span>
                      <input
                        id="input_ten"
                        type="text"
                        name="ten"
                        placeholder="Ví dụ: Nguyễn Văn A"
                        value={formData.ten}
                        onChange={handleChange}
                        required
                      />
                    </div>
                    {formErrors.ten && <span className="ac-field-error">{formErrors.ten}</span>}
                  </div>

                  <div className={`ac-form-group ${formErrors.dienthoai ? 'has-error' : ''}`}>
                    <label htmlFor="input_dienthoai">
                      Số điện thoại <span className="req">*</span>
                    </label>
                    <div className="ac-input-wrapper">
                      <span className="ac-input-icon">📱</span>
                      <input
                        id="input_dienthoai"
                        type="tel"
                        name="dienthoai"
                        placeholder="Ví dụ: 0912 345 678"
                        value={formData.dienthoai}
                        onChange={handleChange}
                        required
                      />
                    </div>
                    {formErrors.dienthoai && <span className="ac-field-error">{formErrors.dienthoai}</span>}
                  </div>
                </div>

                <div className="ac-form-grid-2">
                  <div className={`ac-form-group ${formErrors.diachi ? 'has-error' : ''}`}>
                    <label htmlFor="input_diachi">
                      Địa chỉ liên hệ / Lắp đặt <span className="req">*</span>
                    </label>
                    <div className="ac-input-wrapper">
                      <span className="ac-input-icon">📍</span>
                      <input
                        id="input_diachi"
                        type="text"
                        name="diachi"
                        placeholder="Số nhà, đường, phường/xã, quận/huyện"
                        value={formData.diachi}
                        onChange={handleChange}
                        required
                      />
                    </div>
                    {formErrors.diachi && <span className="ac-field-error">{formErrors.diachi}</span>}
                  </div>

                  <div className="ac-form-group">
                    <label htmlFor="input_email">Email (tùy chọn)</label>
                    <div className="ac-input-wrapper">
                      <span className="ac-input-icon">✉️</span>
                      <input
                        id="input_email"
                        type="email"
                        name="email"
                        placeholder="email@example.com"
                        value={formData.email}
                        onChange={handleChange}
                      />
                    </div>
                  </div>
                </div>

                <div className="ac-form-group">
                  <label htmlFor="input_tieude">Chủ đề cần hỗ trợ</label>
                  <div className="ac-input-wrapper">
                    <span className="ac-input-icon">📑</span>
                    <select
                      id="input_tieude"
                      name="tieude"
                      value={formData.tieude}
                      onChange={handleChange}
                    >
                      <option value="Tư vấn mua máy lạnh giá sỉ">Tư vấn mua máy lạnh mới chính hãng giá sỉ</option>
                      <option value="Báo giá thi công công trình">Báo giá thi công công trình / Dự án lớn</option>
                      <option value="Lắp đặt & Di dời máy lạnh">Lắp đặt & Di dời máy lạnh</option>
                      <option value="Bảo dưỡng & Vệ sinh máy lạnh">Bảo dưỡng & Vệ sinh máy lạnh</option>
                      <option value="Khắc phục sự cố & Sửa chữa">Khắc phục sự cố & Sửa chữa bo mạch / Nạp gas</option>
                      <option value="Khác">Nhu cầu khác</option>
                    </select>
                  </div>
                </div>

                <div className={`ac-form-group ${formErrors.noidung ? 'has-error' : ''}`}>
                  <label htmlFor="input_noidung">
                    Nội dung chi tiết yêu cầu <span className="req">*</span>
                  </label>
                  <textarea
                    id="input_noidung"
                    name="noidung"
                    rows="4"
                    placeholder="Quý khách vui lòng mô tả loại máy, công suất phòng hoặc yêu cầu kỹ thuật cần phục vụ..."
                    value={formData.noidung}
                    onChange={handleChange}
                    required
                  ></textarea>
                  {formErrors.noidung && <span className="ac-field-error">{formErrors.noidung}</span>}
                </div>

                <div className="ac-form-buttons">
                  <button
                    type="submit"
                    className="ac-btn-submit-contact"
                    disabled={isSubmitting}
                  >
                    {isSubmitting ? 'Đang gửi thông tin...' : 'GỬI YÊU CẦU NGAY →'}
                  </button>
                  <button
                    type="button"
                    className="ac-btn-reset-contact"
                    onClick={handleReset}
                  >
                    Nhập lại
                  </button>
                </div>

                <div className="ac-form-guarantee-note">
                  🔒 Thông tin của quý khách được bảo mật tuyệt đối và chỉ dùng để nhân viên liên hệ tư vấn.
                </div>
              </form>
            </div>
          </div>
        </div>

        {/* Google Maps Section */}
        <div className="ac-map-section">
          <div className="ac-section-header">
            <h2 className="ac-section-title">
              <span className="ac-title-accent"></span> Vị Trí Showroom & Kho Hàng Trên Google Maps
            </h2>
            <p className="ac-section-subtitle">
              Địa chỉ: 582 An Dương Vương, Bình Phú, TP. Hồ Chí Minh
            </p>
          </div>

          <div className="ac-map-embed-container">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.8841981751693!2d106.62122387316889!3d10.743407459805708!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752dd6b0e063ef%3A0xaea496c076c61670!2zNTgyIMSQLiBBbiBExrDGoW5nIFbGsMahbmcsIFBoxrDhu51uZyAxMCwgUXXhuq1uIDYsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1706793985589!5m2!1svi!2s"
              width="100%"
              height="450"
              style={{ border: 0, borderRadius: '16px' }}
              allowFullScreen=""
              loading="lazy"
              referrerPolicy="no-referrer-when-downgrade"
              title="MayLanhGiaKho Google Maps Location"
            ></iframe>
          </div>
        </div>

        {/* FAQ Section */}
        <div className="ac-contact-faq-section">
          <div className="ac-section-header text-center">
            <h2 className="ac-section-title">Câu Hỏi Thường Gặp Khi Liên Hệ</h2>
          </div>
          <div className="ac-faq-grid">
            <div className="ac-faq-card">
              <h4>⏱️ Sau khi đặt lịch, bao lâu kỹ thuật viên có mặt?</h4>
              <p>
                Với mạng lưới thợ phủ khắp 24 quận huyện TP.HCM, kỹ thuật viên sẽ có mặt tại nhà quý khách sau 
                <strong> 30 – 45 phút</strong> kể từ khi xác nhận lịch hẹn.
              </p>
            </div>
            <div className="ac-faq-card">
              <h4>💰 Khảo sát địa hình lắp đặt có mất phí không?</h4>
              <p>
                Hoàn toàn <strong>MIỄN PHÍ</strong>! Kỹ thuật viên sẽ đến tận nhà khảo sát hướng gió, vị trí đặt dàn nóng/dàn lạnh, 
                đo đạc tuyến ống đồng và lên báo giá cụ thể trước khi thực hiện.
              </p>
            </div>
            <div className="ac-faq-card">
              <h4>🧾 Máy Lạnh Giá Kho có xuất hóa đơn VAT không?</h4>
              <p>
                Có. Chúng tôi hỗ trợ xuất hóa đơn giá trị gia tăng (VAT) đầy đủ và hợp lệ cho các doanh nghiệp, cơ quan, 
                trường học và nhà hàng khi có yêu cầu.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
