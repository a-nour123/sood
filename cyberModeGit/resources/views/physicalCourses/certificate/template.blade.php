<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شهادة إتمام الكورس</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Inter:wght@300;400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Amiri', serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .certificate {
            width: 297mm;
            height: 210mm;
            background: #ffffff;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .certificate::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(118, 75, 162, 0.1) 0%, transparent 50%),
                linear-gradient(45deg, transparent 49%, rgba(102, 126, 234, 0.03) 50%, transparent 51%);
            pointer-events: none;
        }

        .border-frame {
            position: absolute;
            top: 15mm;
            left: 15mm;
            right: 15mm;
            bottom: 15mm;
            border: 3px solid;
            border-image: linear-gradient(45deg, #667eea, #764ba2, #667eea) 1;
        }

        .inner-border {
            position: absolute;
            top: 20mm;
            left: 20mm;
            right: 20mm;
            bottom: 20mm;
            border: 1px solid rgba(102, 126, 234, 0.3);
        }

        .header {
            text-align: center;
            padding: 25mm 0 15mm 0;
            position: relative;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .certificate-title {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .certificate-subtitle {
            font-size: 18px;
            color: #667eea;
            font-weight: 400;
            margin-bottom: 20px;
        }

        .main-content {
            text-align: center;
            padding: 0 40mm;
            line-height: 1.8;
        }

        .recipient-section {
            margin: 30px 0;
        }

        .this-certifies {
            font-size: 16px;
            color: #4a5568;
            margin-bottom: 15px;
        }

        .recipient-name {
            font-size: 36px;
            font-weight: 700;
            color: #667eea;
            margin: 20px 0;
            text-decoration: underline;
            text-decoration-color: #764ba2;
            text-underline-offset: 8px;
            text-decoration-thickness: 2px;
        }

        .completion-text {
            font-size: 18px;
            color: #2d3748;
            margin: 25px 0;
            line-height: 1.6;
        }

        .course-name {
            font-size: 24px;
            font-weight: 700;
            color: #764ba2;
            margin: 20px 0;
            padding: 15px 30px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 8px;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .details-section {
            display: flex;
            justify-content: space-between;
            margin: 40px 0;
            padding: 0 20mm;
        }

        .detail-box {
            background: #f7fafc;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            min-width: 150px;
            text-align: center;
        }

        .detail-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 20px;
            font-weight: 700;
            color: #667eea;
        }

        .footer {
            position: absolute;
            bottom: 25mm;
            left: 40mm;
            right: 40mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .signature-section {
            text-align: center;
            flex: 1;
        }

        .signature-line {
            width: 150px;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            margin: 0 auto 10px auto;
        }

        .signature-title {
            font-size: 14px;
            color: #4a5568;
            font-weight: 600;
        }

        .certificate-info {
            position: absolute;
            bottom: 10mm;
            right: 15mm;
            font-size: 10px;
            color: #a0aec0;
        }

        .decorative-elements {
            position: absolute;
            top: 30mm;
            left: 25mm;
            width: 40px;
            height: 40px;
            opacity: 0.1;
        }

        .decorative-elements::before,
        .decorative-elements::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: #667eea;
            border-radius: 50%;
        }

        .decorative-elements::before {
            top: 0;
            left: 0;
        }

        .decorative-elements::after {
            bottom: 0;
            right: 0;
            background: #764ba2;
        }

        .decorative-elements-right {
            position: absolute;
            top: 30mm;
            right: 25mm;
            width: 40px;
            height: 40px;
            opacity: 0.1;
            transform: rotate(45deg);
        }

        .decorative-elements-right::before,
        .decorative-elements-right::after {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            background: #764ba2;
        }

        .decorative-elements-right::before {
            top: 0;
            left: 0;
            border-radius: 0 50% 0 50%;
        }

        .decorative-elements-right::after {
            bottom: 0;
            right: 0;
            background: #667eea;
            border-radius: 50% 0 50% 0;
        }

        .grade-badge {
            position: absolute;
            top: 20mm;
            right: 30mm;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            transform: rotate(15deg);
        }

        .english-text {
            font-family: 'Inter', sans-serif;
            direction: ltr;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .certificate {
                box-shadow: none;
                width: 100%;
                height: 100vh;
            }
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="border-frame"></div>
        <div class="inner-border"></div>
        <div class="decorative-elements"></div>
        <div class="decorative-elements-right"></div>

        <div class="grade-badge">
            {{ $percentage }}%
        </div>

        <div class="header">
            <div class="logo">🎓</div>
            <h1 class="certificate-title">شهادة إتمام</h1>
            <p class="certificate-subtitle english-text">Certificate of Completion</p>
        </div>

        <div class="main-content">
            <div class="recipient-section">
                <p class="this-certifies">هذا يشهد أن</p>
                <h2 class="recipient-name">{{ $user->name }}</h2>

                <p class="completion-text">
                    قد أتم بنجاح متطلبات الكورس التدريبي
                </p>

                <div class="course-name">{{ $course->name }}</div>

                <p class="completion-text">
                    وحصل على درجة {{ $grade }} من {{ $fullGrade }}
                    @if($attendedSessions > 0)
                        بنسبة حضور {{ $attendance }}%
                    @endif
                </p>
            </div>

            <div class="details-section">
                <div class="detail-box">
                    <div class="detail-label">النتيجة النهائية</div>
                    <div class="detail-value">{{ $percentage }}%</div>
                </div>

                @if($totalSessions > 0)
                <div class="detail-box">
                    <div class="detail-label">نسبة الحضور</div>
                    <div class="detail-value">{{ $attendance }}%</div>
                </div>
                @endif

                <div class="detail-box">
                    <div class="detail-label">تاريخ الإصدار</div>
                    <div class="detail-value english-text">{{ \Carbon\Carbon::parse($issueDate)->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="signature-section">
                <div class="signature-line"></div>
                <p class="signature-title">المدرب</p>
            </div>

            <div class="signature-section">
                <div class="signature-line"></div>
                <p class="signature-title">مدير التدريب</p>
            </div>
        </div>

        <div class="certificate-info english-text">
            Certificate ID: {{ $certificateId ?? 'CERT-' . $course->id . '-' . $user->id }}<br>
            Issued on: {{ \Carbon\Carbon::parse($issueDate)->format('F d, Y') }}
        </div>
    </div>
</body>
</html>
