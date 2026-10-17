import React, { useState } from 'react';

export default function InstallationGallery() {
  const photos = [
    { src: '/template/images/img_reality1.jpg', title: 'Lắp đặt hệ thống máy lạnh căn hộ chung cư cao cấp' },
    { src: '/template/images/img_reality2.jpg', title: 'Thi công ống đồng âm tường thẩm mỹ nhà phố' },
    { src: '/template/images/img_reality3.jpg', title: 'Lắp đặt máy lạnh Daikin Inverter phòng khách' },
    { src: '/template/images/img_reality4.jpg', title: 'Đội ngũ kỹ thuật viên lắp đặt an toàn chuẩn kỹ thuật' },
    { src: '/template/images/img_reality5.jpg', title: 'Kiểm tra đo áp suất gas và chạy thử bàn giao' },
    { src: '/template/images/img_reality6.jpg', title: 'Hoàn thiện hệ thống điều hòa văn phòng công ty' },
  ];

  const [activePhoto, setActivePhoto] = useState(0);

  return (
    <section
      style={{
        background: '#ffffff',
        border: '1px solid #e2e8f0',
        borderRadius: 20,
        padding: '30px',
        margin: '40px 0',
        boxShadow: '0 1px 3px rgba(0,0,0,0.05)',
      }}
      aria-label="Hình ảnh thực tế thi công lắp đặt"
    >
      <div style={{ textAlign: 'center', marginBottom: 24 }}>
        <h3 style={{ fontSize: 22, fontWeight: 800, color: '#0f172a', margin: '0 0 6px' }}>
          <i className="fa fa-wrench" style={{ color: '#0284c7', marginRight: 8 }}></i>
          Hình Ảnh Thực Tế Thi Công & Lắp Đặt Tận Nơi
        </h3>
        <p style={{ fontSize: 14, color: '#64748b', margin: 0 }}>
          Đội ngũ thợ tay nghề cao trên 10 năm kinh nghiệm - Lắp đặt an toàn, đúng tiêu chuẩn kỹ thuật nhà sản xuất.
        </p>
      </div>

      <div
        style={{
          display: 'grid',
          gridTemplateColumns: 'repeat(auto-fit, minmax(180px, 1fr))',
          gap: 12,
        }}
      >
        {photos.map((item, idx) => {
          const isSelected = activePhoto === idx;
          return (
            <div
              key={idx}
              onClick={() => setActivePhoto(idx)}
              style={{
                borderRadius: 12,
                overflow: 'hidden',
                cursor: 'pointer',
                border: isSelected ? '3px solid #0284c7' : '1px solid #e2e8f0',
                boxShadow: isSelected ? '0 4px 12px rgba(2, 132, 199, 0.25)' : 'none',
                transition: 'all 0.2s',
                position: 'relative',
              }}
            >
              <img
                src={item.src}
                alt={item.title}
                style={{ width: '100%', height: 130, objectFit: 'cover', display: 'block' }}
              />
            </div>
          );
        })}
      </div>

      {/* Featured Big View */}
      <div
        style={{
          marginTop: 18,
          borderRadius: 14,
          overflow: 'hidden',
          background: '#0f172a',
          position: 'relative',
          maxHeight: 420,
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
        }}
      >
        <img
          src={photos[activePhoto].src}
          alt={photos[activePhoto].title}
          style={{ width: '100%', maxHeight: 420, objectFit: 'contain' }}
        />
        <div
          style={{
            position: 'absolute',
            bottom: 0,
            insetInline: 0,
            background: 'linear-gradient(to top, rgba(0,0,0,0.8), transparent)',
            padding: '20px 20px 14px',
            color: '#fff',
            fontSize: 14,
            fontWeight: 600,
          }}
        >
          <i className="fa fa-camera" style={{ marginRight: 8, color: '#38bdf8' }}></i>
          {photos[activePhoto].title}
        </div>
      </div>
    </section>
  );
}
