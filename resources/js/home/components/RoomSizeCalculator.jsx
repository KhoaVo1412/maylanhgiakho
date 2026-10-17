import React, { useState } from 'react';

export default function RoomSizeCalculator({ onApplyHPFilter }) {
  const [isOpen, setIsOpen] = useState(false);
  const [area, setArea] = useState(16);
  const [roomType, setRoomType] = useState('bedroom'); // bedroom, living, sunny
  const [calculatedHP, setCalculatedHP] = useState('1.5 HP');
  const [recommendation, setRecommendation] = useState({
    hp: '1.5 HP',
    btu: '12.000 BTU',
    description: 'Rất thích hợp cho phòng ngủ tiêu chuẩn từ 15m² đến 20m², làm mát êm dịu, tiết kiệm điện.',
  });

  const handleCalculate = (areaVal, typeVal) => {
    const a = parseFloat(areaVal) || 15;
    let factor = 1;
    if (typeVal === 'living') factor = 1.15;
    if (typeVal === 'sunny') factor = 1.25;

    const effectiveArea = a * factor;

    let res = {
      hp: '1.0 HP',
      btu: '9.000 BTU',
      description: 'Phòng nhỏ dưới 15m², công suất làm lạnh nhanh và siêu tiết kiệm điện.',
    };

    if (effectiveArea > 15 && effectiveArea <= 20) {
      res = {
        hp: '1.5 HP',
        btu: '12.000 BTU',
        description: 'Phù hợp phòng ngủ/làm việc từ 15 - 20m², làm lạnh dịu nhẹ, cân bằng nhiệt độ lý tưởng.',
      };
    } else if (effectiveArea > 20 && effectiveArea <= 30) {
      res = {
        hp: '2.0 HP',
        btu: '18.000 BTU',
        description: 'Lựa chọn hoàn hảo cho phòng khách hoặc phòng ngủ lớn 20 - 30m², luồng gió thổi xa.',
      };
    } else if (effectiveArea > 30 && effectiveArea <= 40) {
      res = {
        hp: '2.5 HP',
        btu: '24.000 BTU',
        description: 'Phù hợp không gian rộng 30 - 40m², văn phòng, quán cafe hoặc phòng trần cao.',
      };
    } else if (effectiveArea > 40) {
      res = {
        hp: '≥ 3.0 HP',
        btu: '28.000+ BTU',
        description: 'Không gian lớn trên 40m². Khuyên dùng máy âm trần hoặc lắp kết hợp 2 máy lạnh.',
      };
    }

    setRecommendation(res);
  };

  const handleApply = () => {
    if (onApplyHPFilter) {
      onApplyHPFilter(recommendation.hp);
    }
    setIsOpen(false);
    // Smooth scroll to catalog
    const el = document.getElementById('danh-sach-san-pham');
    if (el) el.scrollIntoView({ behavior: 'smooth' });
  };

  return (
    <>
      <div className="ac-advisor-banner">
        <div className="ac-advisor-info">
          <div className="ac-advisor-icon">
            <i className="fa fa-calculator"></i>
          </div>
          <div>
            <h3>Bạn Chưa Biết Chọn Máy Lạnh Bao Nhiêu Ngựa (HP) Cho Phòng Của Mình?</h3>
            <p>
              Nhập diện tích phòng để hệ thống thông minh tự động gợi ý công suất máy lạnh tối ưu và tiết kiệm điện nhất.
            </p>
          </div>
        </div>
        <button
          type="button"
          className="ac-advisor-btn"
          onClick={() => setIsOpen(true)}
        >
          <i className="fa fa-magic"></i>
          <span>Tính Công Suất Phòng Ngay</span>
        </button>
      </div>

      {/* Modal Dialog */}
      {isOpen && (
        <div className="ac-modal-backdrop" onClick={() => setIsOpen(false)}>
          <div className="ac-modal-content ac-calc-modal" onClick={(e) => e.stopPropagation()}>
            <button
              type="button"
              className="ac-modal-close-btn"
              onClick={() => setIsOpen(false)}
            >
              <i className="fa fa-times"></i>
            </button>

            <h2>
              <i className="fa fa-snowflake-o" style={{ color: '#0284c7', marginRight: 8 }}></i>
              Công Cụ Tính Công Suất Máy Lạnh Theo Diện Tích
            </h2>
            <p className="sub">
              Tính toán chính xác để phòng mát sâu, máy bền lâu và không bị hao phí điện năng.
            </p>

            <div className="ac-calc-inputs">
              <div className="ac-calc-group">
                <label>Diện tích phòng (m²):</label>
                <input
                  type="number"
                  min="5"
                  max="120"
                  value={area}
                  onChange={(e) => {
                    const val = e.target.value;
                    setArea(val);
                    handleCalculate(val, roomType);
                  }}
                />
              </div>

              <div className="ac-calc-group">
                <label>Đặc điểm không gian:</label>
                <select
                  value={roomType}
                  onChange={(e) => {
                    const val = e.target.value;
                    setRoomType(val);
                    handleCalculate(area, val);
                  }}
                >
                  <option value="bedroom">Phòng ngủ gia đình (Ít người, cách nhiệt tốt)</option>
                  <option value="living">Phòng khách / Bếp (Nhiều người ra vào)</option>
                  <option value="sunny">Phòng có hướng nắng chiều trực tiếp / Kính nhiều</option>
                </select>
              </div>
            </div>

            <div className="ac-calc-result-box">
              <h4>CÔNG SUẤT ĐỀ XUẤT CHO BẠN:</h4>
              <div className="hp-highlight">
                {recommendation.hp} ({recommendation.btu})
              </div>
              <p>{recommendation.description}</p>

              <button
                type="button"
                className="ac-slide-btn"
                style={{ background: '#f59e0b', color: '#fff', border: 'none', cursor: 'pointer' }}
                onClick={handleApply}
              >
                <i className="fa fa-filter"></i>
                <span>Xem Ngay Máy Lạnh {recommendation.hp} Phù Hợp</span>
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  );
}
