import React from 'react';

export default function CommitmentBanner() {
  const commitments = [
    {
      icon: 'fa-certificate',
      color: '#0284c7',
      title: '100% Hàng Mới Xuất Xưởng',
      desc: 'Cam kết máy lạnh chính hãng nguyên đai nguyên kiện, kích hoạt bảo hành điện tử chính hãng.',
    },
    {
      icon: 'fa-tags',
      color: '#ef4444',
      title: 'Giá Sỉ Trực Tiếp Tại Kho',
      desc: 'Phân phối từ tổng kho đến tay người tiêu dùng, không qua trung gian, tiết kiệm tối đa chi phí.',
    },
    {
      icon: 'fa-truck',
      color: '#f59e0b',
      title: 'Giao Hỏa Tốc Trong 2H',
      desc: 'Hỗ trợ giao hàng siêu nhanh tại TP.HCM và các tỉnh lân cận, đáp ứng ngay nhu cầu giải nhiệt.',
    },
    {
      icon: 'fa-user-md',
      color: '#10b981',
      title: 'Lắp Đặt Chuẩn Kỹ Thuật',
      desc: 'Đội ngũ thợ chứng chỉ tay nghề cao, hút chân không, vật tư đồng dày chính hãng.',
    },
  ];

  return (
    <section
      style={{
        background: '#ffffff',
        border: '1px solid #e2e8f0',
        borderRadius: 20,
        padding: '36px 30px',
        margin: '40px 0 20px',
        boxShadow: '0 4px 12px rgba(0,0,0,0.03)',
      }}
      aria-label="Cam kết chất lượng Máy Lạnh Giá Kho"
    >
      <div style={{ textAlign: 'center', maxWidth: 600, margin: '0 auto 28px' }}>
        <h3 style={{ fontSize: 22, fontWeight: 800, color: '#0f172a', margin: '0 0 6px' }}>
          Cam Kết Vàng Khi Mua Hàng Tại Máy Lạnh Giá Kho
        </h3>
        <p style={{ fontSize: 14, color: '#64748b', margin: 0 }}>
          Sự tin tưởng và hài lòng của hơn 15.000+ khách hàng là minh chứng cho chất lượng dịch vụ của chúng tôi.
        </p>
      </div>

      <div
        style={{
          display: 'grid',
          gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))',
          gap: 20,
        }}
      >
        {commitments.map((item, idx) => (
          <div
            key={idx}
            style={{
              padding: '20px',
              borderRadius: 14,
              background: '#f8fafc',
              border: '1px solid #f1f5f9',
              display: 'flex',
              flexDirection: 'column',
              alignItems: 'center',
              textAlign: 'center',
            }}
          >
            <div
              style={{
                width: 52,
                height: 52,
                borderRadius: '50%',
                background: '#ffffff',
                border: `2px solid ${item.color}`,
                color: item.color,
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontSize: 22,
                marginBottom: 14,
                boxShadow: '0 4px 10px rgba(0,0,0,0.05)',
              }}
            >
              <i className={`fa ${item.icon}`}></i>
            </div>
            <h4 style={{ fontSize: 16, fontWeight: 700, margin: '0 0 8px', color: '#1e293b' }}>
              {item.title}
            </h4>
            <p style={{ fontSize: 13, color: '#64748b', margin: 0, lineHeight: 1.5 }}>
              {item.desc}
            </p>
          </div>
        ))}
      </div>
    </section>
  );
}
