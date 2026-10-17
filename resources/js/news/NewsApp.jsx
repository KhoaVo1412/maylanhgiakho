import React, { useState, useMemo } from 'react';

export default function NewsApp({ initialData = {} }) {
  const rawPosts = initialData.tintucs || [];
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedTag, setSelectedTag] = useState('all');

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

  // Resolve image helper
  const resolveImage = (img) => {
    if (!img) return '/template/images/icons/iconml.png';
    if (img.startsWith('http://') || img.startsWith('https://')) return img;
    if (img.startsWith('/')) return img;
    return `/${img}`;
  };

  // Static helpful articles if database has only a few items
  const curatedGuides = [
    {
      id: 'guide-1',
      title: 'Cách Tính Công Suất Máy Lạnh Theo Diện Tích & Thể Tích Phòng Chuẩn Xác',
      slug: 'may-lanh-hang-casper-co-tot-khong-va-dang-mua-o-nam-2024-va-2025',
      category: 'Tư vấn chọn mua',
      image: '/template/images/icons/iconml.png',
      date: '2025-01-10',
      desc: 'Hướng dẫn công thức tính BTU và HP cho phòng ngủ, phòng khách, phòng có cửa kính hoặc bị nắng hướng tây để máy bền và tiết kiệm điện tối đa.',
      badge: 'Cẩm nang hay',
    },
    {
      id: 'guide-2',
      title: '5 Mẹo Dùng Máy Lạnh Inverter Tiết Kiệm Đến 40% Tiền Điện Hàng Tháng',
      slug: 'may-lanh-hang-casper-co-tot-khong-va-dang-mua-o-nam-2024-va-2025',
      category: 'Mẹo tiết kiệm điện',
      image: '/template/images/icons/iconml.png',
      date: '2025-01-08',
      desc: 'Nhiều người dùng sai cách khiến máy lạnh Inverter vẫn tốn điện. Xem ngay các thiết lập nhiệt độ 26-28°C và chế độ Eco chuẩn chuyên gia.',
      badge: 'Mẹo hữu ích',
    },
    {
      id: 'guide-3',
      title: 'Dấu Hiệu Máy Lạnh Hết Gas, Thiếu Gas & Cách Nhận Biết Chính Xác',
      slug: 'may-lanh-hang-casper-co-tot-khong-va-dang-mua-o-nam-2024-va-2025',
      category: 'Kinh nghiệm kỹ thuật',
      image: '/template/images/icons/iconml.png',
      date: '2025-01-05',
      desc: 'Máy chạy nhưng không mát, ống đồng bám tuyết trắng, máy tự ngắt sau vài phút... Khi nào cần nạp gas R32, R410A và chi phí hết bao nhiêu?',
      badge: 'Kỹ thuật',
    },
  ];

  // Combined posts list
  const allArticles = useMemo(() => {
    const list = [...rawPosts];
    // If database has very few posts, blend in curated guides so the page looks rich and helpful
    if (list.length < 3) {
      curatedGuides.forEach((g) => {
        if (!list.some((item) => item.name === g.title)) {
          list.push({
            id: g.id,
            name: g.title,
            slug: g.slug,
            image: g.image,
            description: g.desc,
            created_at: g.date,
            category: g.category,
            badge: g.badge,
          });
        }
      });
    }
    return list;
  }, [rawPosts]);

  // Filtered Articles
  const filteredArticles = useMemo(() => {
    return allArticles.filter((item) => {
      const matchSearch =
        !searchTerm ||
        (item.name && item.name.toLowerCase().includes(searchTerm.toLowerCase())) ||
        (item.description && item.description.toLowerCase().includes(searchTerm.toLowerCase()));

      const matchTag =
        selectedTag === 'all' ||
        (selectedTag === 'tu-van' && (item.name.toLowerCase().includes('mua') || item.name.toLowerCase().includes('chọn') || item.name.toLowerCase().includes('tốt'))) ||
        (selectedTag === 'tiet-kiem' && item.name.toLowerCase().includes('tiết kiệm')) ||
        (selectedTag === 'ky-thuat' && (item.name.toLowerCase().includes('gas') || item.name.toLowerCase().includes('vệ sinh') || item.name.toLowerCase().includes('lắp')));

      return matchSearch && matchTag;
    });
  }, [allArticles, searchTerm, selectedTag]);

  // Featured first post
  const featuredPost = filteredArticles.length > 0 ? filteredArticles[0] : null;
  const remainingPosts = filteredArticles.length > 1 ? filteredArticles.slice(1) : [];

  return (
    <div className="ac-app ac-news-page">
      {/* Breadcrumb */}
      <div className="ac-breadcrumb-wrap">
        <div className="ac-container">
          <ul className="ac-breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li>/</li>
            <li className="active">Tin tức & Cẩm nang</li>
          </ul>
        </div>
      </div>

      <div className="ac-container">
        {/* Hero Section */}
        <div className="ac-news-hero">
          <span className="ac-news-hero-tag">📰 Cẩm Nang Chuyên Sâu</span>
          <h1 className="ac-news-hero-title">Tin Tức & Kinh Nghiệm Sử Dụng Máy Lạnh</h1>
          <p className="ac-news-hero-desc">
            Cập nhật xu hướng công nghệ làm lạnh mới nhất, hướng dẫn chọn công suất máy lạnh chuẩn xác 
            và những bí quyết vàng giúp máy lạnh chạy êm ái, bền bỉ, tiết kiệm điện năng cho gia đình.
          </p>
        </div>

        {/* Toolbar: Category Tags & Search */}
        <div className="ac-news-toolbar">
          <div className="ac-news-tags">
            <button
              type="button"
              className={`ac-ntag ${selectedTag === 'all' ? 'active' : ''}`}
              onClick={() => setSelectedTag('all')}
            >
              Tất cả bài viết
            </button>
            <button
              type="button"
              className={`ac-ntag ${selectedTag === 'tu-van' ? 'active' : ''}`}
              onClick={() => setSelectedTag('tu-van')}
            >
              Tư vấn chọn mua
            </button>
            <button
              type="button"
              className={`ac-ntag ${selectedTag === 'tiet-kiem' ? 'active' : ''}`}
              onClick={() => setSelectedTag('tiet-kiem')}
            >
              Mẹo tiết kiệm điện
            </button>
            <button
              type="button"
              className={`ac-ntag ${selectedTag === 'ky-thuat' ? 'active' : ''}`}
              onClick={() => setSelectedTag('ky-thuat')}
            >
              Kinh nghiệm kỹ thuật
            </button>
          </div>

          <div className="ac-news-search">
            {/* <span className="ac-search-icon">🔍</span> */}
            <input
              type="text"
              placeholder="Tìm kiếm bài viết, thương hiệu, lỗi máy lạnh..."
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

        {/* Main Content Layout with Sidebar */}
        <div className="ac-news-layout-grid">
          {/* Left Column: News Articles */}
          <div className="ac-news-feed-col">
            {filteredArticles.length === 0 ? (
              <div className="ac-empty-news">
                <div className="ac-empty-icon">📰</div>
                <h3>Không tìm thấy bài viết nào phù hợp</h3>
                <p>Vui lòng thử lại với từ khóa khác hoặc bấm xem tất cả bài viết.</p>
                <button
                  type="button"
                  className="ac-btn-reset-search"
                  onClick={() => {
                    setSearchTerm('');
                    setSelectedTag('all');
                  }}
                >
                  Xem tất cả bài viết
                </button>
              </div>
            ) : (
              <>
                {/* Featured Post Card */}
                {featuredPost && (
                  <div className="ac-featured-post-card">
                    <a href={`/tintuc-detail/${featuredPost.slug}`} className="ac-featured-img-wrap">
                      <img src={resolveImage(featuredPost.image)} alt={featuredPost.name} />
                      <span className="ac-featured-badge">Bài viết tiêu biểu</span>
                    </a>
                    <div className="ac-featured-content">
                      <div className="ac-post-meta">
                        <span>📅 {formatDate(featuredPost.created_at)}</span>
                        <span>✍️ Chuyên gia MayLanhGiaKho</span>
                      </div>
                      <h2 className="ac-featured-title">
                        <a href={`/tintuc-detail/${featuredPost.slug}`}>{featuredPost.name}</a>
                      </h2>
                      <p className="ac-featured-excerpt">
                        {featuredPost.description || 'Tìm hiểu chi tiết các dòng máy lạnh chính hãng giá kho cùng đánh giá thực tế từ kỹ thuật viên...'}
                      </p>
                      <a href={`/tintuc-detail/${featuredPost.slug}`} className="ac-btn-read-featured">
                        Đọc toàn bộ bài viết →
                      </a>
                    </div>
                  </div>
                )}

                {/* Remaining Post Grid */}
                {remainingPosts.length > 0 && (
                  <div className="ac-news-grid">
                    {remainingPosts.map((post) => (
                      <article key={post.id} className="ac-post-card">
                        <a href={`/tintuc-detail/${post.slug}`} className="ac-post-img-wrap">
                          <img src={resolveImage(post.image)} alt={post.name} loading="lazy" />
                          <span className="ac-post-tag-badge">Máy Lạnh Chính Hãng</span>
                        </a>
                        <div className="ac-post-body">
                          <div className="ac-post-meta">
                            <span>📅 {formatDate(post.created_at)}</span>
                          </div>
                          <h3 className="ac-post-title">
                            <a href={`/tintuc-detail/${post.slug}`}>{post.name}</a>
                          </h3>
                          <p className="ac-post-desc">
                            {post.description ? post.description.slice(0, 110) + '...' : 'Thông tin chi tiết về sản phẩm và cẩm nang điện lạnh hữu ích...'}
                          </p>
                          <a href={`/tintuc-detail/${post.slug}`} className="ac-post-link">
                            Đọc tiếp <span>→</span>
                          </a>
                        </div>
                      </article>
                    ))}
                  </div>
                )}
              </>
            )}
          </div>

          {/* Right Column: Helpful Guides & Promotion Widgets */}
          <div className="ac-news-sidebar-col">
            {/* Quick Consultation Card */}
            <div className="ac-sidebar-card ac-sidebar-hotline-box">
              <span className="ac-side-badge">Hỗ Trợ Nhanh</span>
              <h4>Cần Tư Vấn Mua Máy Hoặc Sửa Chữa?</h4>
              <p>Đội ngũ chuyên viên điện lạnh sẵn sàng tư vấn giải pháp tối ưu và tiết kiệm nhất cho bạn.</p>
              <a href="tel:0583593999" className="ac-side-hotline-btn">
                <span>📞</span> 0583 593 999
              </a>
              <a href="https://zalo.me/0583593999" target="_blank" rel="noopener noreferrer" className="ac-side-zalo-btn">
                Chat Zalo Tư Vấn Miễn Phí
              </a>
            </div>

            {/* Energy-Saving Tips Widget */}
            <div className="ac-sidebar-card">
              <h4 className="ac-side-card-title">💡 Bí Quyết Dùng Máy Lạnh Tiết Kiệm Điện</h4>
              <ul className="ac-side-tips-list">
                <li>
                  <span className="ac-tip-num">1</span>
                  <div>
                    <strong>Cài đặt nhiệt độ 26°C – 28°C</strong>
                    <p>Kết hợp bật quạt gió nhẹ giúp không khí lan tỏa đều, tiết kiệm 15% điện năng.</p>
                  </div>
                </li>
                <li>
                  <span className="ac-tip-num">2</span>
                  <div>
                    <strong>Vệ sinh lưới lọc bụi 1 tháng/lần</strong>
                    <p>Lưới lọc sạch giúp luồng gió lưu thông mạnh, máy không phải gồng tải nặng.</p>
                  </div>
                </li>
                <li>
                  <span className="ac-tip-num">3</span>
                  <div>
                    <strong>Bảo dưỡng xịt rửa 3 - 6 tháng/lần</strong>
                    <p>Làm sạch dàn nóng ngoài trời để tản nhiệt nhanh, kéo dài tuổi thọ block máy nén.</p>
                  </div>
                </li>
                <li>
                  <span className="ac-tip-num">4</span>
                  <div>
                    <strong>Đóng kín cửa và kéo rèm che nắng</strong>
                    <p>Hạn chế nhiệt lượng bức xạ từ ánh nắng mặt trời làm giảm độ lạnh của phòng.</p>
                  </div>
                </li>
              </ul>
            </div>

            {/* Quick Price List Callout */}
            <div className="ac-sidebar-card ac-side-promo-card">
              <h4>📋 Bảng Giá Lắp Đặt & Vệ Sinh Máy Lạnh</h4>
              <p>Xem đơn giá nhân công, ống đồng Thái Lan và dịch vụ nạp gas niêm yết công khai.</p>
              <a href="/banggia" className="ac-side-btn-view-price">
                Xem bảng giá chi tiết →
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
