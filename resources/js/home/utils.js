/**
 * Helper utilities for Air Conditioner (Máy Lạnh) e-commerce logic
 */

export function formatVND(amount) {
  if (!amount || isNaN(amount)) return 'Liên hệ';
  return new Intl.NumberFormat('vi-VN').format(amount) + ' đ';
}

export function calculateDiscount(price, priceSale) {
  if (!price || !priceSale || price <= priceSale) return 0;
  return Math.round(((price - priceSale) / price) * 100);
}

export function removeVietnameseTones(str) {
  if (!str) return '';
  str = String(str);
  str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, 'a');
  str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, 'e');
  str = str.replace(/ì|í|ị|ỉ|ĩ/g, 'i');
  str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, 'o');
  str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, 'u');
  str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, 'y');
  str = str.replace(/đ/g, 'd');
  str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, 'A');
  str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, 'E');
  str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, 'I');
  str = str.replace(/Ò|Ó|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, 'O');
  str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, 'U');
  str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, 'Y');
  str = str.replace(/Đ/g, 'D');
  str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, '');
  str = str.replace(/\u02C6|\u0306|\u031B/g, '');
  return str.toLowerCase().trim();
}

export function extractHP(product) {
  if (!product) return '1.0 HP';

  const rawMaluc = String(product.maluc || '').trim().toLowerCase();
  const text = ((product.name || '') + ' ' + (product.model || '') + ' ' + (product.slug || '')).toLowerCase();

  // 1. Explicit maluc field in DB
  if (rawMaluc) {
    if (rawMaluc.includes('1.5') || rawMaluc.includes('1,5')) return '1.5 HP';
    if (rawMaluc.includes('2.5') || rawMaluc.includes('2,5')) return '2.5 HP';
    if (rawMaluc.includes('3') || rawMaluc.includes('4') || rawMaluc.includes('5')) return '≥ 3.0 HP';
    if (rawMaluc.includes('2')) return '2.0 HP';
    if (rawMaluc.includes('1')) return '1.0 HP';
  }

  // 2. Parse text with HP / Ngựa keywords
  if (
    /1[.,]5\s*(hp|ngựa|ngua)/i.test(text) ||
    text.includes('12000') ||
    text.includes('12.000') ||
    text.includes('13000') ||
    /(xpu|wpu|n|u|h)12[a-z0-9]*/i.test(text) ||
    /(ras-h)13/i.test(text) ||
    /(ftkb|ftkc|ftkf|ftky|atkb|atkc)35/i.test(text)
  ) {
    return '1.5 HP';
  }

  if (
    /2[.,]5\s*(hp|ngựa|ngua)/i.test(text) ||
    text.includes('24000') ||
    text.includes('24.000') ||
    /(xpu|wpu|n|u|h)24[a-z0-9]*/i.test(text) ||
    /(ftkb|ftkc|ftkf|ftky|atkb|atkc)60/i.test(text)
  ) {
    return '2.5 HP';
  }

  if (
    /[345][.,]?\d*\s*(hp|ngựa|ngua)/i.test(text) ||
    text.includes('28000') ||
    text.includes('30000') ||
    text.includes('36000') ||
    text.includes('48000')
  ) {
    return '≥ 3.0 HP';
  }

  if (
    /2([.,]0)?\s*(hp|ngựa|ngua)/i.test(text) ||
    text.includes('18000') ||
    text.includes('18.000') ||
    /(xpu|wpu|n|u|h)18[a-z0-9]*/i.test(text) ||
    /(ras-h)18/i.test(text) ||
    /(ftkb|ftkc|ftkf|ftky|atkb|atkc)50/i.test(text)
  ) {
    return '2.0 HP';
  }

  if (
    /1([.,]0)?\s*(hp|ngựa|ngua)/i.test(text) ||
    text.includes('9000') ||
    text.includes('9.000') ||
    text.includes('9.500') ||
    text.includes('9500') ||
    /(xpu|wpu|n|u|h)0?9[a-z0-9]*/i.test(text) ||
    /(ras-h|ftk[a-z]|fthf)10/i.test(text) ||
    /(cfs-)10/i.test(text) ||
    /(ftkb|ftkc|ftkf|ftky|atkb|atkc)25/i.test(text)
  ) {
    return '1.0 HP';
  }

  return '1.0 HP';
}

export function getRecommendedArea(hp) {
  if (!hp) return 'Phù hợp nhiều không gian';
  if (hp.includes('1.0')) return 'Phòng < 15 m²';
  if (hp.includes('1.5')) return 'Phòng 15 - 20 m²';
  if (hp.includes('2.0')) return 'Phòng 20 - 30 m²';
  if (hp.includes('2.5')) return 'Phòng 30 - 40 m²';
  if (hp.includes('3') || hp.includes('4') || hp.includes('5')) return 'Phòng > 40 m²';
  return 'Phù hợp nhiều không gian';
}

export function isInverter(product) {
  if (!product) return false;
  const text = ((product.name || '') + ' ' + (product.model || '') + ' ' + (product.description || '')).toLowerCase();
  return text.includes('inverter') || text.includes('tiết kiệm điện');
}

export function isGasR32(product) {
  if (!product) return false;
  const gas = String(product.loaigas || '').toLowerCase();
  const text = ((product.name || '') + ' ' + (product.model || '') + ' ' + (product.description || '')).toLowerCase();
  return gas.includes('32') || text.includes('r32') || text.includes('r-32');
}

export function getGasType(product) {
  if (!product) return 'Gas R32';
  const gas = String(product.loaigas || '').toLowerCase();
  if (gas.includes('410')) return 'Gas R410A';
  if (gas.includes('32')) return 'Gas R32';

  const text = ((product.name || '') + ' ' + (product.description || '')).toLowerCase();
  if (text.includes('r410')) return 'Gas R410A';
  if (text.includes('r32') || text.includes('r-32')) return 'Gas R32';

  return 'Gas R32';
}
