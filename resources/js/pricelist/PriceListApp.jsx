import React, { useState, useMemo } from 'react';

export default function PriceListApp({ initialData = {} }) {
  const [activeTab, setActiveTab] = useState('all');
  const [searchQuery, setSearchQuery] = useState('');
  
  // Interactive Calculator State
  const [calcHp, setCalcHp] = useState('1.0'); // 1.0, 2.0
  const [calcPipeLength, setCalcPipeLength] = useState(3); // meters
  const [calcNeedClean, setCalcNeedClean] = useState(false);
  const [calcNeedGas, setCalcNeedGas] = useState(false);
  const [calcRemoveOld, setCalcRemoveOld] = useState(false);

  // Modal State for Quick Booking
  const [bookingItem, setBookingItem] = useState(null);

  // Master Price Database
  const priceCategories = [
    {
      id: 'nhan-cong',
      name: '1. Nhân công lắp đặt máy lạnh',
      badge: 'Công thợ',
      icon: '👨‍🔧',
      items: [
        {
          id: '1.1',
          name: 'Nhân công lắp đặt máy lạnh treo tường (Công suất 1.0 – 1.5 HP)',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '350.000',
          priceVal: 350000,
          highlight: 'Khuyên dùng',
          note: 'Bao gồm hút chân không máy Inverter chuyên dụng',
        },
        {
          id: '1.2',
          name: 'Nhân công lắp đặt máy lạnh treo tường (Công suất 2.0 – 2.5 HP)',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '500.000 - 700.000',
          priceVal: 500000,
          highlight: '',
          note: 'Bao gồm hút chân không máy Inverter',
        },
        {
          id: '1.3',
          name: 'Nhân công tháo máy lạnh treo tường 02 cụm cũ',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '200.000',
          priceVal: 200000,
          highlight: '',
          note: 'Khóa gas an toàn, tháo gọn gàng sạch sẽ',
        },
        {
          id: '1.4',
          name: 'Nhân công đục tường sửa đường ống gas âm tường + hàn ống',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '200.000',
          priceVal: 200000,
          highlight: '',
          note: 'Trường hợp ống đi âm tường bị sai vị trí hoặc ống đồng bị gãy móp',
        },
        {
          id: '1.5',
          name: 'Nhân công xúc rửa đường ống đồng bằng khí Nitơ chuyên dụng',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '200.000',
          priceVal: 200000,
          highlight: '',
          note: 'Trường hợp ống âm sẵn lâu ngày hoặc ống cũ dùng lại để tránh tắc nghẹt',
        },
      ],
    },
    {
      id: 'vat-tu',
      name: '2. Vật tư lắp đặt (Nghiệm thu theo thực tế)',
      badge: 'Vật tư chính hãng',
      icon: '⚙️',
      items: [
        {
          id: '2.1',
          name: 'Ống gas 6.4×9.5mm, dày 0.71mm (kèm gen cách nhiệt, xi quấn) – Dùng cho máy 1.0 - 1.5 HP',
          origin: 'Thái Lan',
          unit: 'Mét',
          qty: '01',
          priceText: '150.000',
          priceVal: 150000,
          highlight: 'Chuẩn 100% Thái Lan',
          note: 'Bảo ôn đôi riêng biệt từng ống',
        },
        {
          id: '2.2',
          name: 'Ống gas 6.4×12.7mm, dày 0.71mm (kèm gen cách nhiệt, xi quấn) – Dùng cho máy 2.0 – 2.5 HP Inverter',
          origin: 'Thái Lan',
          unit: 'Mét',
          qty: '01',
          priceText: '190.000',
          priceVal: 190000,
          highlight: 'Chuẩn 100% Thái Lan',
          note: 'Bảo ôn đôi riêng biệt từng ống',
        },
        {
          id: '2.3',
          name: 'Ống gas 6.4×15.9mm, dày 0.7×0.8mm (kèm gen cách nhiệt, xi quấn) – Dùng cho máy 2.5 HP',
          origin: 'Thái Lan',
          unit: 'Mét',
          qty: '01',
          priceText: '300.000',
          priceVal: 300000,
          highlight: '',
          note: 'Ống đồng cây dày chuyên cho máy công suất lớn',
        },
        {
          id: '2.4',
          name: 'Dây điện nguồn & điều khiển 2.0mm',
          origin: 'Daphaco',
          unit: 'Mét',
          qty: '01',
          priceText: '12.000',
          priceVal: 12000,
          highlight: '',
          note: 'Dây đồng nguyên chất chống cháy',
        },
        {
          id: '2.5',
          name: 'Ống thoát nước mềm ruột gà',
          origin: 'Việt Nam',
          unit: 'Mét',
          qty: '01',
          priceText: '10.000',
          priceVal: 10000,
          highlight: '',
          note: 'Độ dẻo dai cao, không bị gấp khúc',
        },
        {
          id: '2.6',
          name: 'Ống thoát nước PVC phi 21 (Bao gồm co, lơ, keo dán)',
          origin: 'Bình Minh',
          unit: 'Mét',
          qty: '01',
          priceText: '35.000',
          priceVal: 35000,
          highlight: 'Độ bền vĩnh cửu',
          note: 'Khuyên dùng cho nhà mới, chống thấm tường tối đa',
        },
        {
          id: '2.7',
          name: 'CB điện tự động + Hộp điện an toàn 32A',
          origin: 'MPE',
          unit: 'Bộ',
          qty: '01',
          priceText: '150.000',
          priceVal: 150000,
          highlight: '',
          note: 'Tự ngắt khi chập điện quá tải',
        },
        {
          id: '2.8',
          name: 'Eke treo dàn nóng máy lạnh treo tường 1.0HP – 2.5 Hp',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '150.000 - 300.000',
          priceVal: 150000,
          highlight: '',
          note: 'Thép sơn tĩnh điện chống rỉ sét ngoài trời',
        },
      ],
    },
    {
      id: 've-sinh-may-lanh',
      name: '3. Dịch vụ bảo trì – Vệ sinh máy lạnh',
      badge: 'Bảo dưỡng định kỳ',
      icon: '❄️',
      items: [
        {
          id: '3.1',
          name: 'Bảo trì, vệ sinh máy lạnh Treo Tường 02 cụm (Cân chỉnh gas Miễn Phí)',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '200.000',
          priceVal: 200000,
          highlight: 'Tặng cân chỉnh gas',
          note: 'Vệ sinh kỹ dàn nóng + dàn lạnh + kiểm tra ampe',
        },
        {
          id: '3.2',
          name: 'Bảo trì, vệ sinh máy lạnh Treo Tường (Cân chỉnh gas Miễn Phí) – Từ 03 Máy/Lần',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '180.000',
          priceVal: 180000,
          highlight: 'Ưu đãi số lượng',
          note: 'Tiết kiệm chi phí cho gia đình hoặc văn phòng',
        },
        {
          id: '3.3',
          name: 'Bảo trì, vệ sinh máy lạnh Casset Âm Trần thổi đa hướng (Cân chỉnh gas Miễn Phí)',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '500.000',
          priceVal: 500000,
          highlight: '',
          note: 'Tháo mặt nạ xịt rửa dàn trao đổi nhiệt, máng nước thải',
        },
        {
          id: '3.4',
          name: 'Bảo trì, vệ sinh máy lạnh Tủ Đứng (Cân chỉnh gas Miễn Phí)',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '450.000',
          priceVal: 450000,
          highlight: '',
          note: 'Vệ sinh công suất lớn cho nhà hàng, showroom, quán cafe',
        },
        {
          id: '3.5',
          name: 'Sạc gas bổ sung (Tùy công suất máy – Gas R410A, R32, R22) – Báo giá trực tiếp',
          origin: 'USA / Ấn Độ',
          unit: 'Bộ',
          qty: '01',
          priceText: '350.000',
          priceVal: 350000,
          highlight: 'Gas xịn chính hãng',
          note: 'Độ tinh khiết cao, máy lạnh sâu nhanh chóng',
        },
      ],
    },
    {
      id: 've-sinh-may-giat',
      name: '4. Dịch vụ bảo trì – Vệ sinh máy giặt',
      badge: 'Thiết bị gia đình',
      icon: '🧺',
      items: [
        {
          id: '4.1',
          name: 'Bảo trì, vệ sinh máy giặt Lồng Đứng (Cửa trên)',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '350.000',
          priceVal: 350000,
          highlight: 'Tháo lồng xịt sạch',
          note: 'Tẩy sạch cặn bẩn, xơ vải, nấm mốc trong lồng giặt',
        },
        {
          id: '4.2',
          name: 'Bảo trì, vệ sinh máy giặt Lồng Ngang (Cửa trước)',
          origin: 'Việt Nam',
          unit: 'Bộ',
          qty: '01',
          priceText: '750.000',
          priceVal: 750000,
          highlight: 'Kỹ thuật tay nghề cao',
          note: 'Tháo toàn bộ lồng, vệ sinh gioăng cao su, bảo dưỡng bạc đạn',
        },
      ],
    },
  ];

  // Filtering items by category & search
  const filteredCategories = useMemo(() => {
    return priceCategories
      .map((cat) => {
        if (activeTab !== 'all' && cat.id !== activeTab) return null;
        const matchingItems = cat.items.filter((item) => {
          if (!searchQuery) return true;
          const q = searchQuery.toLowerCase();
          return (
            item.name.toLowerCase().includes(q) ||
            item.id.toLowerCase().includes(q) ||
            (item.origin && item.origin.toLowerCase().includes(q)) ||
            (item.note && item.note.toLowerCase().includes(q))
          );
        });
        if (matchingItems.length === 0) return null;
        return {
          ...cat,
          items: matchingItems,
        };
      })
      .filter(Boolean);
  }, [activeTab, searchQuery]);

  // Calculator Result
  const estimatedTotal = useMemo(() => {
    let labor = calcHp === '1.0' ? 350000 : 500000;
    let pipePricePerMeter = calcHp === '1.0' ? 150000 : 190000;
    let pipeCost = calcPipeLength * pipePricePerMeter;
    let electricCable = calcPipeLength * 12000;
    let drainPipe = calcPipeLength * 10000;
    let eke = 150000;
    let cb = 150000;

    let total = labor + pipeCost + electricCable + drainPipe + eke + cb;

    if (calcRemoveOld) total += 200000;
    if (calcNeedClean) total += 180000;
    if (calcNeedGas) total += 350000;

    return total;
  }, [calcHp, calcPipeLength, calcRemoveOld, calcNeedClean, calcNeedGas]);

  return (
    <div className="ac-app ac-pricelist-page">
      {/* Breadcrumb */}
      <div className="ac-breadcrumb-wrap">
        <div className="ac-container">
          <ul className="ac-breadcrumb">
            <li className="active">Bảng giá dịch vụ</li>
          </ul>
        </div>
      </div>

      <div className="ac-container">
        {/* Hero Section */}
        <div className="ac-pricelist-hero">
          <div className="ac-pricelist-hero-text">
            <span className="ac-price-hero-tag">📋 Niêm Yết Minh Bạch - Cạnh Tranh Nhất TP.HCM</span>
            <h1 className="ac-price-hero-title">
              Bảng Giá Dịch Vụ Lắp Đặt, Vật Tư & Bảo Trì Máy Lạnh 2025
            </h1>
            <p className="ac-price-hero-desc">
              Tất cả đơn giá nhân công, ống đồng Thái Lan và vật tư phụ trợ được công khai 100%. 
              Kỹ thuật viên nghiệm thu thực tế theo số mét thi công. Cam kết <strong>bảo hành chất lượng lắp đặt 12 tháng</strong>.
            </p>
          </div>
          <div className="ac-price-hero-actions">
            <a href="tel:0583593999" className="ac-btn-hotline-pulse">
              <span className="ac-pulse-icon">📞</span>
              <span>
                <small>Tư vấn & Báo giá nhanh</small>
                <strong>0583 593 999</strong>
              </span>
            </a>
            <a href="https://zalo.me/0583593999" target="_blank" rel="noopener noreferrer" className="ac-btn-zalo-hero">
              <span className="ac-zalo-badge">Zalo</span>
              <span>Gửi ảnh khảo sát</span>
            </a>
          </div>
        </div>

        {/* Highlight Trust Strip */}
        <div className="ac-price-trust-strip">
          <div className="ac-price-trust-item">
            <span className="ac-pt-icon">🛡️</span>
            <div>
              <strong>Bảo Hành 12 Tháng</strong>
              <small>Miễn phí xử lý rò rỉ, bảo dưỡng sau lắp đặt</small>
            </div>
          </div>
          <div className="ac-price-trust-item">
            <span className="ac-pt-icon">🇹🇭</span>
            <div>
              <strong>Ống Đồng Thái Lan 100%</strong>
              <small>Dày 0.71mm - 0.81mm, bảo ôn đôi riêng biệt</small>
            </div>
          </div>
          <div className="ac-price-trust-item">
            <span className="ac-pt-icon">💨</span>
            <div>
              <strong>Hút Chân Không Miễn Phí</strong>
              <small>Bắt buộc cho máy Inverter, làm lạnh sâu bền bỉ</small>
            </div>
          </div>
          <div className="ac-price-trust-item">
            <span className="ac-pt-icon">📝</span>
            <div>
              <strong>Nghiệm Thu Thực Tế</strong>
              <small>Đo đếm số mét chính xác trước khi thanh toán</small>
            </div>
          </div>
        </div>

        {/* Interactive Price Estimator Tool */}
        <div className="ac-calc-card">
          <div className="ac-calc-header">
            <div className="ac-calc-title-wrap">
              <span className="ac-calc-badge">⚡ Tiện Ích Độc Quyền</span>
              <h3>Công Cụ Dự Toán Chi Phí Lắp Đặt Nhanh</h3>
              <p>Chọn các thông số dưới đây để nhận ngay dự toán chi phí trọn gói sơ bộ:</p>
            </div>
            <div className="ac-calc-result-box">
              <span className="ac-calc-res-label">Chi Phí Dự Kiến Ước Tính:</span>
              <div className="ac-calc-res-num">{estimatedTotal.toLocaleString('vi-VN')} đ</div>
              <small>* Đã bao gồm nhân công, ống đồng, eke, CB, dây điện & phụ kiện</small>
            </div>
          </div>

          <div className="ac-calc-grid">
            <div className="ac-calc-field">
              <label>Công suất máy lạnh:</label>
              <div className="ac-calc-pill-group">
                <button
                  type="button"
                  className={`ac-calc-pill ${calcHp === '1.0' ? 'active' : ''}`}
                  onClick={() => setCalcHp('1.0')}
                >
                  1.0 HP – 1.5 HP (Phòng ≤ 20m²)
                </button>
                <button
                  type="button"
                  className={`ac-calc-pill ${calcHp === '2.0' ? 'active' : ''}`}
                  onClick={() => setCalcHp('2.0')}
                >
                  2.0 HP – 2.5 HP (Phòng 20 - 40m²)
                </button>
              </div>
            </div>

            <div className="ac-calc-field">
              <label>
                Chiều dài ống đồng dự kiến: <strong>{calcPipeLength} mét</strong>
              </label>
              <div className="ac-calc-slider-wrap">
                <input
                  type="range"
                  min="2"
                  max="15"
                  step="1"
                  value={calcPipeLength}
                  onChange={(e) => setCalcPipeLength(Number(e.target.value))}
                />
                <div className="ac-slider-labels">
                  <span>2m (Tối thiểu)</span>
                  <span>5m</span>
                  <span>10m</span>
                  <span>15m</span>
                </div>
              </div>
            </div>

            <div className="ac-calc-field full-width">
              <label>Dịch vụ / Yêu cầu kèm theo:</label>
              <div className="ac-calc-checkboxes">
                <label className="ac-calc-check-label">
                  <input
                    type="checkbox"
                    checked={calcRemoveOld}
                    onChange={(e) => setCalcRemoveOld(e.target.checked)}
                  />
                  <span>Tháo dỡ máy lạnh cũ (+200.000đ)</span>
                </label>
                <label className="ac-calc-check-label">
                  <input
                    type="checkbox"
                    checked={calcNeedClean}
                    onChange={(e) => setCalcNeedClean(e.target.checked)}
                  />
                  <span>Vệ sinh xịt rửa bảo dưỡng (+180.000đ)</span>
                </label>
                <label className="ac-calc-check-label">
                  <input
                    type="checkbox"
                    checked={calcNeedGas}
                    onChange={(e) => setCalcNeedGas(e.target.checked)}
                  />
                  <span>Nạp bổ sung Gas R32/R410A (+350.000đ)</span>
                </label>
              </div>
            </div>
          </div>

          <div className="ac-calc-footer">
            <span className="ac-calc-hint">
              💡 Bạn cần tư vấn chi tiết địa hình lắp đặt thực tế?
            </span>
            <a
              href={`https://zalo.me/0583593999?text=${encodeURIComponent(
                `Chào MayLanhGiaKho, tôi cần tư vấn lắp đặt máy ${calcHp} HP, ống đồng khoảng ${calcPipeLength}m, dự toán khoảng ${estimatedTotal.toLocaleString('vi-VN')}đ.`
              )}`}
              target="_blank"
              rel="noopener noreferrer"
              className="ac-btn-send-estimate"
            >
              Gửi dự toán này qua Zalo để nhân viên tư vấn
            </a>
          </div>
        </div>

        {/* Filter and Search Bar for Price Tables */}
        <div className="ac-price-toolbar">
          <div className="ac-price-tabs">
            <button
              type="button"
              className={`ac-ptab ${activeTab === 'all' ? 'active' : ''}`}
              onClick={() => setActiveTab('all')}
            >
              Tất cả hạng mục
            </button>
            <button
              type="button"
              className={`ac-ptab ${activeTab === 'nhan-cong' ? 'active' : ''}`}
              onClick={() => setActiveTab('nhan-cong')}
            >
              1. Nhân công lắp đặt
            </button>
            <button
              type="button"
              className={`ac-ptab ${activeTab === 'vat-tu' ? 'active' : ''}`}
              onClick={() => setActiveTab('vat-tu')}
            >
              2. Vật tư lắp đặt
            </button>
            <button
              type="button"
              className={`ac-ptab ${activeTab === 've-sinh-may-lanh' ? 'active' : ''}`}
              onClick={() => setActiveTab('ve-sinh-may-lanh')}
            >
              3. Vệ sinh & Nạp gas
            </button>
            <button
              type="button"
              className={`ac-ptab ${activeTab === 've-sinh-may-giat' ? 'active' : ''}`}
              onClick={() => setActiveTab('ve-sinh-may-giat')}
            >
              4. Vệ sinh máy giặt
            </button>
          </div>

          <div className="ac-price-search">
            {/* <span className="ac-search-icon">🔍</span> */}
            <input
              type="text"
              placeholder="Tìm bảng giá: ống đồng, vệ sinh, âm trần, gas..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
            />
            {searchQuery && (
              <button type="button" className="ac-search-clear" onClick={() => setSearchQuery('')}>
                ✕
              </button>
            )}
          </div>
        </div>

        {/* Tables by Category */}
        <div className="ac-price-tables-wrap">
          {filteredCategories.length === 0 ? (
            <div className="ac-empty-results">
              <div className="ac-empty-icon">🔎</div>
              <h4>Không tìm thấy hạng mục nào phù hợp</h4>
              <p>Thử tìm kiếm với từ khóa khác như "ống đồng", "vệ sinh", "nhân công"</p>
              <button type="button" className="ac-btn-reset-search" onClick={() => setSearchQuery('')}>
                Xóa từ khóa tìm kiếm
              </button>
            </div>
          ) : (
            filteredCategories.map((cat) => (
              <div key={cat.id} className="ac-price-section-block">
                <div className="ac-table-header-bar">
                  <div className="ac-table-header-title">
                    <span className="ac-table-icon">{cat.icon}</span>
                    <h2>{cat.name}</h2>
                  </div>
                  <span className="ac-cat-badge">{cat.badge}</span>
                </div>

                <div className="ac-table-responsive-wrapper">
                  <table className="ac-price-table">
                    <thead>
                      <tr>
                        <th style={{ width: '60px', textAlign: 'center' }}>STT</th>
                        <th>Nội Dung Hạng Mục / Dịch Vụ</th>
                        <th style={{ width: '110px', textAlign: 'center' }}>Xuất Xứ</th>
                        <th style={{ width: '80px', textAlign: 'center' }}>ĐVT</th>
                        <th style={{ width: '70px', textAlign: 'center' }}>SL</th>
                        <th style={{ width: '170px', textAlign: 'right' }}>Đơn Giá (VNĐ)</th>
                        <th style={{ width: '130px', textAlign: 'center' }}>Thao Tác</th>
                      </tr>
                    </thead>
                    <tbody>
                      {cat.items.map((item) => (
                        <tr key={item.id} className="ac-price-row">
                          <td className="text-center font-bold ac-col-stt">{item.id}</td>
                          <td className="ac-col-name">
                            <div className="ac-item-name-wrap">
                              <span className="ac-item-name">{item.name}</span>
                              {item.highlight && (
                                <span className="ac-item-pill-tag">{item.highlight}</span>
                              )}
                            </div>
                            {item.note && <div className="ac-item-note">📌 {item.note}</div>}
                          </td>
                          <td className="text-center ac-col-origin">
                            <span className="ac-origin-badge">{item.origin}</span>
                          </td>
                          <td className="text-center ac-col-unit">{item.unit}</td>
                          <td className="text-center ac-col-qty">{item.qty}</td>
                          <td className="text-right ac-col-price">
                            <span className="ac-price-val">{item.priceText}</span>
                          </td>
                          <td className="text-center ac-col-action">
                            <button
                              type="button"
                              className="ac-btn-order-service"
                              onClick={() => setBookingItem(item)}
                            >
                              Đặt mục này
                            </button>
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
            ))
          )}
        </div>

        {/* Important Notes & Standards Box */}
        <div className="ac-price-notes-box">
          <div className="ac-notes-header">
            <span className="ac-notes-icon">📌</span>
            <h3>Quý Khách Hàng Lưu Ý Khi Sử Dụng Dịch Vụ</h3>
          </div>
          <div className="ac-notes-grid">
            <div className="ac-note-item">
              <span className="ac-note-bullet">•</span>
              <p>
                <strong>Đơn giá tính theo VNĐ:</strong> Giá trên chưa bao gồm thuế VAT (nếu xuất hóa đơn công ty).
              </p>
            </div>
            <div className="ac-note-item">
              <span className="ac-note-bullet">•</span>
              <p>
                <strong>Độ dày ống đồng chuẩn:</strong> Ống đồng Thái Lan dày 0.71mm cho ống Ø6, Ø10, Ø12; Dày 0.8mm cho ống Ø16, Ø19.
              </p>
            </div>
            <div className="ac-note-item">
              <span className="ac-note-bullet">•</span>
              <p>
                <strong>Quy định bảo hành hãng:</strong> Các hãng máy lạnh (Daikin, Panasonic, Casper, Mitsubishi) chỉ áp dụng bảo hành khi sử dụng lắp đặt bảo ôn đôi (mỗi ống đồng đi riêng 1 đường bảo ôn cách nhiệt).
              </p>
            </div>
            <div className="ac-note-item">
              <span className="ac-note-bullet">•</span>
              <p>
                <strong>Hút chân không bắt buộc:</strong> Máy lạnh Inverter bắt buộc phải hút chân không bằng máy chuyên dụng để làm sạch không khí và hơi ẩm trong đường ống.
              </p>
            </div>
            <div className="ac-note-item">
              <span className="ac-note-bullet">•</span>
              <p>
                <strong>Kiểm tra ống âm sẵn:</strong> Đối với ống đồng đi âm tường có sẵn, kỹ thuật viên sẽ tiến hành test áp lực và xúc rửa khí Nitơ để tránh cặn bẩn làm cháy lốc máy.
              </p>
            </div>
            <div className="ac-note-item">
              <span className="ac-note-bullet">•</span>
              <p>
                <strong>Cam kết bảo hành lắp đặt:</strong> Bảo hành chất lượng lắp đặt miễn phí <strong>12 tháng</strong> kể từ ngày ký biên bản nghiệm thu.
              </p>
            </div>
          </div>
        </div>

        {/* Direct Call Banner */}
        <div className="ac-price-cta-banner">
          <div className="ac-cta-banner-content">
            <h3>Cần Khảo Sát Báo Giá Chi Tiết Theo Công Trình Thực Tế?</h3>
            <p>
              Gọi ngay hoặc gửi thông tin qua Zalo (số lượng máy, bản vẽ mặt bằng). 
              Chúng tôi sẽ gửi bảng dự toán chi tiết kèm chiết khấu tốt nhất trong 15 phút!
            </p>
          </div>
          <div className="ac-cta-banner-buttons">
            <a href="tel:0583593999" className="ac-cta-phone-btn">
              <span>📞</span> 0583 593 999
            </a>
            <a href="https://zalo.me/0583593999" target="_blank" rel="noopener noreferrer" className="ac-cta-zalo-btn">
              Chat Zalo Báo Giá
            </a>
            <a href="/contact" className="ac-cta-contact-btn">
              Gửi biểu mẫu liên hệ
            </a>
          </div>
        </div>
      </div>

      {/* Quick Booking Modal */}
      {bookingItem && (
        <div className="ac-modal-backdrop" onClick={() => setBookingItem(null)}>
          <div className="ac-booking-modal" onClick={(e) => e.stopPropagation()}>
            <button type="button" className="ac-modal-close" onClick={() => setBookingItem(null)}>
              ✕
            </button>
            <div className="ac-modal-header">
              <span className="ac-modal-badge">Đặt dịch vụ</span>
              <h4>{bookingItem.name}</h4>
              <div className="ac-modal-price">
                Đơn giá: <strong>{bookingItem.priceText} VNĐ / {bookingItem.unit}</strong>
              </div>
            </div>

            <div className="ac-modal-body">
              <p>Quý khách vui lòng chọn hình thức liên hệ nhanh nhất để kỹ thuật viên phục vụ ngay:</p>

              <div className="ac-modal-actions">
                <a href="tel:0583593999" className="ac-modal-btn ac-modal-call">
                  <span>📞</span>
                  <div>
                    <strong>Gọi ngay: 0583 593 999</strong>
                    <small>Tổng đài trực 24/7 có mặt sau 30 phút</small>
                  </div>
                </a>

                <a
                  href={`https://zalo.me/0583593999?text=${encodeURIComponent(
                    `Tôi muốn đặt dịch vụ: ${bookingItem.name} (Đơn giá: ${bookingItem.priceText} VNĐ). Vui lòng tư vấn cho tôi.`
                  )}`}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="ac-modal-btn ac-modal-zalo"
                >
                  <span>💬</span>
                  <div>
                    <strong>Chat Zalo nhận tư vấn ngay</strong>
                    <small>Gửi hình ảnh và vị trí lắp đặt</small>
                  </div>
                </a>

                <a
                  href={`/contact?note=${encodeURIComponent(`Tôi muốn đặt dịch vụ: ${bookingItem.name}`)}`}
                  className="ac-modal-btn ac-modal-form"
                >
                  <span>📝</span>
                  <div>
                    <strong>Điền form thông tin liên hệ</strong>
                    <small>Nhân viên sẽ gọi lại sau 5 phút</small>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
