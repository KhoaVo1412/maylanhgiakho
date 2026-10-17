import React, { useState } from 'react';

export default function JapaneseAcSection() {
  const images = [
    '/template/maynoidia/55.jpg',
    '/template/maynoidia/22.jpg',
    '/template/maynoidia/11.jpg',
    '/template/maynoidia/77.jpg',
    '/template/maynoidia/33.jpg',
    '/template/maynoidia/44.jpg',
    '/template/maynoidia/66.jpg',
  ];

  const [currentIndex, setCurrentIndex] = useState(0);

  const prev = () => {
    setCurrentIndex((prev) => (prev === 0 ? images.length - 1 : prev - 1));
  };

  const next = () => {
    setCurrentIndex((prev) => (prev === images.length - 1 ? 0 : prev + 1));
  };

  return (
    <section
      style={{
        background: 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)',
        color: '#fff',
        borderRadius: 20,
        padding: '36px 30px',
        margin: '40px 0',
        boxShadow: '0 10px 25px rgba(0,0,0,0.15)',
        position: 'relative',
        overflow: 'hidden',
      }}
      aria-label="Máy lạnh nội địa Nhật Bản"
    >
      <div style={{ textAlign: 'center', maxWidth: 650, margin: '0 auto 26px' }}>
        <span
          style={{
            background: 'linear-gradient(135deg, #ef4444 0%, #b91c1c 100%)',
            color: '#fff',
            fontSize: 11,
            fontWeight: 800,
            padding: '4px 12px',
            borderRadius: 20,
            textTransform: 'uppercase',
            letterSpacing: 0.5,
          }}
        >
          HÀNG TUYỂN CHỌN SIÊU BỀN
        </span>
        <h2 style={{ fontSize: 24, fontWeight: 800, margin: '10px 0 8px', color: '#fff' }}>
          Chuyên Máy Lạnh Nội Địa Nhật Bản (Tiết Kiệm Điện 60%)
        </h2>
        <p style={{ fontSize: 14, color: '#94a3b8', margin: 0 }}>
          Dòng máy lạnh cao cấp chạy êm ái, 2 chiều nóng/lạnh, cảm biến mắt thần Eco thông minh, độ bền nồi đồng cối đá.
        </p>
      </div>

      {/* Showcase Carousel */}
      <div
        style={{
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          gap: 15,
          position: 'relative',
        }}
      >
        <button
          type="button"
          onClick={prev}
          style={{
            background: 'rgba(255,255,255,0.15)',
            border: 'none',
            color: '#fff',
            width: 44,
            height: 44,
            borderRadius: '50%',
            cursor: 'pointer',
            fontSize: 18,
            backdropFilter: 'blur(4px)',
            transition: 'all 0.2s',
          }}
          aria-label="Xem ảnh trước"
        >
          ❮
        </button>

        <div
          style={{
            maxWidth: 600,
            width: '100%',
            borderRadius: 14,
            overflow: 'hidden',
            boxShadow: '0 8px 24px rgba(0,0,0,0.3)',
            background: '#ffffff',
            padding: 10,
          }}
        >
          <img
            src={images[currentIndex]}
            alt={`Máy lạnh nội địa Nhật ${currentIndex + 1}`}
            style={{ width: '100%', height: 320, objectFit: 'contain', display: 'block' }}
          />
        </div>

        <button
          type="button"
          onClick={next}
          style={{
            background: 'rgba(255,255,255,0.15)',
            border: 'none',
            color: '#fff',
            width: 44,
            height: 44,
            borderRadius: '50%',
            cursor: 'pointer',
            fontSize: 18,
            backdropFilter: 'blur(4px)',
            transition: 'all 0.2s',
          }}
          aria-label="Xem ảnh sau"
        >
          ❯
        </button>
      </div>

      {/* Japanese AC Benefits */}
      <div
        style={{
          display: 'grid',
          gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))',
          gap: 15,
          marginTop: 28,
        }}
      >
        <div style={{ background: 'rgba(255,255,255,0.06)', padding: 14, borderRadius: 10, textAlign: 'center' }}>
          <i className="fa fa-plug" style={{ fontSize: 20, color: '#38bdf8', marginBottom: 6 }}></i>
          <h4 style={{ margin: '0 0 4px', fontSize: 13, color: '#f1f5f9' }}>Siêu Tiết Kiệm Điện</h4>
          <p style={{ margin: 0, fontSize: 12, color: '#94a3b8' }}>Tiết kiệm đến 60% hóa đơn tiền điện mỗi tháng</p>
        </div>

        <div style={{ background: 'rgba(255,255,255,0.06)', padding: 14, borderRadius: 10, textAlign: 'center' }}>
          <i className="fa fa-volume-off" style={{ fontSize: 20, color: '#38bdf8', marginBottom: 6 }}></i>
          <h4 style={{ margin: '0 0 4px', fontSize: 13, color: '#f1f5f9' }}>Vận Hành Siêu Êm</h4>
          <p style={{ margin: 0, fontSize: 12, color: '#94a3b8' }}>Độ ồn cực thấp &lt; 19dB, giấc ngủ sâu dịu êm</p>
        </div>

        <div style={{ background: 'rgba(255,255,255,0.06)', padding: 14, borderRadius: 10, textAlign: 'center' }}>
          <i className="fa fa-shield-alt" style={{ fontSize: 20, color: '#38bdf8', marginBottom: 6 }}></i>
          <h4 style={{ margin: '0 0 4px', fontSize: 13, color: '#f1f5f9' }}>Bảo Hành Uy Tín</h4>
          <p style={{ margin: 0, fontSize: 12, color: '#94a3b8' }}>Bao test đổi mới, bảo hành 12 - 24 tháng chu đáo</p>
        </div>
      </div>
    </section>
  );
}
