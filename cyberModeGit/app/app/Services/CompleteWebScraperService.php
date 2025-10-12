<?php
// First Version support JavaScript-heavy websites (SPAs) and regular HTML pages.

// namespace App\Services;

// use DOMDocument;
// use DOMXPath;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Log;

// class CompleteWebScraperService
// {
//     private $baseUrl;
//     private $downloadedAssets = [];
//     private $assetPath = 'scraped-assets';

//     public function scrapeCompleteWebsite($url, $customHtml = null)
//     {
//         try {
//             // التحقق من صحة الـ URL
//             if (!filter_var($url, FILTER_VALIDATE_URL)) {
//                 throw new \Exception('Invalid URL provided');
//             }

//             // استخراج الـ base URL
//             $this->baseUrl = $this->getBaseUrl($url);

//             $html = '';

//             // إذا كان فيه custom HTML (للـ SPA)، استخدمه
//             if (!empty($customHtml)) {
//                 $html = $customHtml;
//                 Log::info('Using custom HTML for SPA processing');
//             } else {
//                 // جلب الـ HTML الأساسي للمواقع العادية
//                 $response = Http::timeout(30)
//                     ->withHeaders([
//                         'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
//                     ])
//                     ->get($url);

//                 if (!$response->successful()) {
//                     throw new \Exception('Failed to fetch the website. HTTP Status: ' . $response->status());
//                 }

//                 $html = $response->body();
//             }

//             if (empty($html)) {
//                 throw new \Exception('Empty HTML content received');
//             }

//             // معالجة الـ HTML وتحميل الأصول
//             $processedHtml = $this->processHtml($html, $url, !empty($customHtml));

//             return [
//                 'html' => $processedHtml,
//                 'assets' => $this->downloadedAssets,
//                 'status' => 'success',
//                 'is_spa_mode' => !empty($customHtml)
//             ];

//         } catch (\Exception $e) {
//             Log::error('Web scraping failed: ' . $e->getMessage(), [
//                 'url' => $url ?? 'unknown',
//                 'is_custom_html' => !empty($customHtml),
//                 'trace' => $e->getTraceAsString()
//             ]);

//             return [
//                 'html' => null,
//                 'assets' => [],
//                 'status' => 'error',
//                 'message' => $e->getMessage(),
//                 'is_spa_mode' => !empty($customHtml)
//             ];
//         }
//     }

//     private function processHtml($html, $originalUrl, $isSpaMode = false)
//     {
//         try {
//             $dom = new DOMDocument();
//             libxml_use_internal_errors(true);

//             // تحسين تحميل الـ HTML
//             $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

//             // للـ SPA: التأكد من وجود هيكل HTML صحيح
//             if ($isSpaMode) {
//                 $html = $this->ensureValidHtmlStructure($html);
//             } else {
//                 // للمواقع العادية: إضافة هيكل HTML إذا لم يكن موجود
//                 if (!preg_match('/<html[^>]*>/i', $html)) {
//                     $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $html . '</body></html>';
//                 } else if (!preg_match('/<body[^>]*>/i', $html)) {
//                     $html = preg_replace('/(<html[^>]*>)/i', '$1<head><meta charset="UTF-8"></head><body>', $html);
//                     $html .= '</body>';
//                 }
//             }

//             $success = $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

//             if (!$success) {
//                 throw new \Exception('Failed to parse HTML document');
//             }

//             libxml_clear_errors();
//             $xpath = new DOMXPath($dom);

//             if (!$xpath) {
//                 throw new \Exception('Failed to create XPath object');
//             }

//             // معالجة الأصول بنفس الطريقة للمواقع العادية والـ SPA
//             $this->processCssFiles($xpath, $dom);
//             $this->processInlineStyles($xpath, $dom);
//             $this->processImages($xpath, $dom);
//             $this->processJavaScriptFiles($xpath, $dom);
//             $this->processFonts($xpath, $dom);
//             $this->addCharsetMeta($dom);

//             // للـ SPA: إضافة تعليق للتوضيح
//             if ($isSpaMode) {
//                 $this->addSpaComment($dom);
//             }

//             $finalHtml = $dom->saveHTML();

//             // التأكد من الهيكل النهائي
//             if (!preg_match('/<html[^>]*>/i', $finalHtml)) {
//                 $finalHtml = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $finalHtml . '</body></html>';
//             }

//             return $finalHtml;

//         } catch (\Exception $e) {
//             Log::error('HTML processing failed: ' . $e->getMessage(), [
//                 'is_spa_mode' => $isSpaMode
//             ]);
//             throw new \Exception('Failed to process HTML: ' . $e->getMessage());
//         }
//     }

//     private function ensureValidHtmlStructure($html)
//     {
//         // إذا كان الـ HTML يحتوي على تاج html كامل، استخدمه كما هو
//         if (preg_match('/<html[^>]*>.*<\/html>/is', $html)) {
//             return $html;
//         }

//         // إذا كان يحتوي على body فقط، أضف head
//         if (preg_match('/<body[^>]*>/i', $html)) {
//             if (!preg_match('/<head[^>]*>/i', $html)) {
//                 $html = preg_replace('/(<body[^>]*>)/i', '<head><meta charset="UTF-8"></head>$1', $html);
//             }
//             if (!preg_match('/<html[^>]*>/i', $html)) {
//                 $html = '<!DOCTYPE html><html>' . $html . '</html>';
//             }
//             return $html;
//         }

//         // إذا كان محتوى body فقط، أضف الهيكل الكامل
//         return '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $html . '</body></html>';
//     }

//     private function addSpaComment($dom)
//     {
//         try {
//             $comment = $dom->createComment(' This content was extracted from a Single Page Application (SPA) ');
//             $body = $dom->getElementsByTagName('body');
//             if ($body && $body->length > 0) {
//                 $bodyElement = $body->item(0);
//                 $bodyElement->insertBefore($comment, $bodyElement->firstChild);
//             }
//         } catch (\Exception $e) {
//             Log::warning('Failed to add SPA comment: ' . $e->getMessage());
//         }
//     }

//     // باقي الدوال تبقى كما هي...
//     private function processCssFiles($xpath, $dom)
//     {
//         try {
//             $linkElements = $xpath->query('//link[@rel="stylesheet"][@href]');

//             if ($linkElements === false) {
//                 Log::warning('XPath query for CSS files failed');
//                 return;
//             }

//             foreach ($linkElements as $link) {
//                 try {
//                     $href = $link->getAttribute('href');

//                     if (empty($href)) {
//                         continue;
//                     }

//                     $absoluteUrl = $this->makeAbsoluteUrl($href);
//                     $cssContent = $this->downloadAsset($absoluteUrl, 'css');

//                     if ($cssContent) {
//                         $processedCss = $this->processCssContent($cssContent, $absoluteUrl);
//                         $localPath = $this->saveAsset($processedCss, 'css', $href);

//                         if ($localPath) {
//                             $link->setAttribute('href', $localPath);
//                         }
//                     }
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process CSS file: ' . $href . ' - ' . $e->getMessage());
//                     continue;
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('CSS processing failed: ' . $e->getMessage());
//         }
//     }

//     private function processInlineStyles($xpath, $dom)
//     {
//         try {
//             $styleElements = $xpath->query('//style');

//             if ($styleElements === false) {
//                 Log::warning('XPath query for inline styles failed');
//                 return;
//             }

//             foreach ($styleElements as $style) {
//                 try {
//                     $cssContent = $style->textContent;
//                     if (!empty($cssContent)) {
//                         $processedCss = $this->processCssContent($cssContent, $this->baseUrl);
//                         $style->textContent = $processedCss;
//                     }
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process inline style: ' . $e->getMessage());
//                     continue;
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('Inline styles processing failed: ' . $e->getMessage());
//         }
//     }

//     private function processCssContent($cssContent, $baseUrl)
//     {
//         if (empty($cssContent)) {
//             return $cssContent;
//         }

//         try {
//             $pattern = '/url\s*\(\s*[\'"]?([^\'"\)]+)[\'"]?\s*\)/i';

//             return preg_replace_callback($pattern, function($matches) use ($baseUrl) {
//                 try {
//                     $url = trim($matches[1]);

//                     if (strpos($url, 'data:') === 0 || strpos($url, 'http') === 0) {
//                         return $matches[0];
//                     }

//                     $absoluteUrl = $this->makeAbsoluteUrl($url, $baseUrl);
//                     $localPath = $this->downloadAndSaveAsset($absoluteUrl);

//                     return $localPath ? "url('{$localPath}')" : $matches[0];
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process CSS URL: ' . ($url ?? 'unknown') . ' - ' . $e->getMessage());
//                     return $matches[0];
//                 }
//             }, $cssContent);
//         } catch (\Exception $e) {
//             Log::warning('CSS content processing failed: ' . $e->getMessage());
//             return $cssContent;
//         }
//     }

//     private function processImages($xpath, $dom)
//     {
//         try {
//             $imgElements = $xpath->query('//img[@src]');

//             if ($imgElements === false) {
//                 Log::warning('XPath query for images failed');
//                 return;
//             }

//             foreach ($imgElements as $img) {
//                 try {
//                     $src = $img->getAttribute('src');

//                     if (!empty($src) && strpos($src, 'data:') !== 0) {
//                         $absoluteUrl = $this->makeAbsoluteUrl($src);
//                         $localPath = $this->downloadAndSaveAsset($absoluteUrl);

//                         if ($localPath) {
//                             $img->setAttribute('src', $localPath);
//                         }
//                     }
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process image: ' . ($src ?? 'unknown') . ' - ' . $e->getMessage());
//                     continue;
//                 }
//             }

//             // معالجة background images في الـ style attributes
//             $elementsWithStyle = $xpath->query('//*[@style]');

//             if ($elementsWithStyle !== false) {
//                 foreach ($elementsWithStyle as $element) {
//                     try {
//                         $style = $element->getAttribute('style');
//                         if (!empty($style)) {
//                             $updatedStyle = $this->processCssContent($style, $this->baseUrl);
//                             $element->setAttribute('style', $updatedStyle);
//                         }
//                     } catch (\Exception $e) {
//                         Log::warning('Failed to process element style: ' . $e->getMessage());
//                         continue;
//                     }
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('Image processing failed: ' . $e->getMessage());
//         }
//     }

//     private function processJavaScriptFiles($xpath, $dom)
//     {
//         try {
//             $scriptElements = $xpath->query('//script[@src]');

//             if ($scriptElements === false) {
//                 Log::warning('XPath query for JavaScript files failed');
//                 return;
//             }

//             foreach ($scriptElements as $script) {
//                 try {
//                     $src = $script->getAttribute('src');

//                     if (!empty($src)) {
//                         $absoluteUrl = $this->makeAbsoluteUrl($src);
//                         $jsContent = $this->downloadAsset($absoluteUrl, 'js');

//                         if ($jsContent) {
//                             $localPath = $this->saveAsset($jsContent, 'js', $src);
//                             if ($localPath) {
//                                 $script->setAttribute('src', $localPath);
//                             }
//                         }
//                     }
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process JS file: ' . ($src ?? 'unknown') . ' - ' . $e->getMessage());
//                     continue;
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('JavaScript processing failed: ' . $e->getMessage());
//         }
//     }

//     private function processFonts($xpath, $dom)
//     {
//         try {
//             $linkElements = $xpath->query('//link[@href*="fonts.googleapis.com"] | //link[@href*="fonts.google.com"]');

//             if ($linkElements === false) {
//                 Log::warning('XPath query for fonts failed');
//                 return;
//             }

//             foreach ($linkElements as $link) {
//                 try {
//                     $href = $link->getAttribute('href');
//                     if (!empty($href)) {
//                         $cssContent = $this->downloadAsset($href, 'css');

//                         if ($cssContent) {
//                             $processedCss = $this->processCssContent($cssContent, $href);
//                             $localPath = $this->saveAsset($processedCss, 'css', $href);
//                             if ($localPath) {
//                                 $link->setAttribute('href', $localPath);
//                             }
//                         }
//                     }
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process font: ' . ($href ?? 'unknown') . ' - ' . $e->getMessage());
//                     continue;
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('Font processing failed: ' . $e->getMessage());
//         }
//     }

//     private function downloadAsset($url, $type = null)
//     {
//         try {
//             if (empty($url)) {
//                 return false;
//             }

//             $response = Http::timeout(15)
//                 ->withHeaders([
//                     'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
//                 ])
//                 ->get($url);

//             if ($response->successful() && !empty($response->body())) {
//                 return $response->body();
//             }

//             Log::warning("Asset download failed: {$url} - HTTP Status: " . $response->status());
//         } catch (\Exception $e) {
//             Log::warning("Failed to download asset: {$url} - " . $e->getMessage());
//         }

//         return false;
//     }

//     private function downloadAndSaveAsset($url)
//     {
//         $content = $this->downloadAsset($url);

//         if ($content !== false) {
//             return $this->saveAsset($content, null, $url);
//         }

//         return false;
//     }

//     private function saveAsset($content, $type = null, $originalUrl = null)
//     {
//         try {
//             if (empty($content)) {
//                 return false;
//             }

//             $filename = $this->generateFilename($originalUrl, $type, $content);
//             $publicPath = 'public/' . $this->assetPath . '/' . $filename;

//             if (!Storage::exists(dirname($publicPath))) {
//                 Storage::makeDirectory(dirname($publicPath));
//             }

//             Storage::put($publicPath, $content);
//             $assetUrl = asset('storage/' . $this->assetPath . '/' . $filename);

//             $this->downloadedAssets[] = [
//                 'original_url' => $originalUrl,
//                 'local_path' => $publicPath,
//                 'asset_url' => $assetUrl
//             ];

//             return $assetUrl;
//         } catch (\Exception $e) {
//             Log::error('Failed to save asset: ' . $e->getMessage(), [
//                 'original_url' => $originalUrl,
//                 'type' => $type
//             ]);
//             return false;
//         }
//     }

//     private function generateFilename($url, $type = null, $content = null)
//     {
//         $hash = md5(($url ?? 'unknown') . time() . rand());

//         if ($type) {
//             return $hash . '.' . $type;
//         }

//         $extension = '';

//         if ($url) {
//             $urlPath = parse_url($url, PHP_URL_PATH);
//             if ($urlPath) {
//                 $extension = pathinfo($urlPath, PATHINFO_EXTENSION);
//                 $extension = preg_replace('/\?.*$/', '', $extension);
//             }
//         }

//         if (empty($extension) && $content) {
//             $extension = $this->getExtensionFromContent($content);
//         }

//         if (empty($extension) && $url) {
//             $extension = $this->guessExtensionFromUrl($url);
//         }

//         if (empty($extension)) {
//             $extension = 'asset';
//         }

//         return $hash . '.' . $extension;
//     }

//     private function getExtensionFromContent($content)
//     {
//         $firstBytes = substr($content, 0, 20);

//         if (strpos($firstBytes, "\xFF\xD8\xFF") === 0) {
//             return 'jpg';
//         }

//         if (strpos($firstBytes, "\x89PNG\r\n\x1A\n") === 0) {
//             return 'png';
//         }

//         if (strpos($firstBytes, "GIF87a") === 0 || strpos($firstBytes, "GIF89a") === 0) {
//             return 'gif';
//         }

//         if (strpos($firstBytes, "RIFF") === 0 && strpos($firstBytes, "WEBP") !== false) {
//             return 'webp';
//         }

//         if (strpos($content, '<svg') !== false) {
//             return 'svg';
//         }

//         if (preg_match('/^\s*(@import|@charset|\/\*|[a-zA-Z#\.\-_].*\{)/m', $content)) {
//             return 'css';
//         }

//         if (preg_match('/(function\s*\(|var\s+|let\s+|const\s+|if\s*\(|for\s*\(|while\s*\()/m', $content)) {
//             return 'js';
//         }

//         if (strpos($firstBytes, "wOFF") === 0) {
//             return 'woff';
//         }
//         if (strpos($firstBytes, "wOF2") === 0) {
//             return 'woff2';
//         }

//         return '';
//     }

//     private function guessExtensionFromUrl($url)
//     {
//         if (strpos($url, 'image') !== false) {
//             if (strpos($url, 'jpeg') !== false || strpos($url, 'jpg') !== false) {
//                 return 'jpg';
//             }
//             if (strpos($url, 'png') !== false) {
//                 return 'png';
//             }
//             if (strpos($url, 'gif') !== false) {
//                 return 'gif';
//             }
//             if (strpos($url, 'webp') !== false) {
//                 return 'webp';
//             }
//             if (strpos($url, 'svg') !== false) {
//                 return 'svg';
//             }
//             return 'jpg';
//         }

//         if (strpos($url, 'font') !== false || strpos($url, 'woff') !== false) {
//             if (strpos($url, 'woff2') !== false) {
//                 return 'woff2';
//             }
//             return 'woff';
//         }

//         if (strpos($url, 'css') !== false || strpos($url, 'style') !== false) {
//             return 'css';
//         }

//         if (strpos($url, 'js') !== false || strpos($url, 'javascript') !== false) {
//             return 'js';
//         }

//         return '';
//     }

//     private function makeAbsoluteUrl($url, $baseUrl = null)
//     {
//         try {
//             if (empty($url)) {
//                 return '';
//             }

//             $baseUrl = $baseUrl ?? $this->baseUrl;

//             if (filter_var($url, FILTER_VALIDATE_URL)) {
//                 return $url;
//             }

//             if (strpos($url, '//') === 0) {
//                 return 'https:' . $url;
//             }

//             if (strpos($url, '/') === 0) {
//                 $parsedBase = parse_url($baseUrl);
//                 if ($parsedBase && isset($parsedBase['scheme']) && isset($parsedBase['host'])) {
//                     return $parsedBase['scheme'] . '://' . $parsedBase['host'] . $url;
//                 }
//             }

//             return rtrim($baseUrl, '/') . '/' . ltrim($url, '/');
//         } catch (\Exception $e) {
//             Log::warning('Failed to make absolute URL: ' . $e->getMessage(), [
//                 'url' => $url,
//                 'baseUrl' => $baseUrl
//             ]);
//             return $url;
//         }
//     }

//     private function getBaseUrl($url)
//     {
//         try {
//             $parsed = parse_url($url);
//             if ($parsed && isset($parsed['scheme']) && isset($parsed['host'])) {
//                 return $parsed['scheme'] . '://' . $parsed['host'];
//             }
//             throw new \Exception('Invalid URL structure');
//         } catch (\Exception $e) {
//             Log::error('Failed to get base URL: ' . $e->getMessage(), ['url' => $url]);
//             throw new \Exception('Invalid URL provided');
//         }
//     }

//     private function addCharsetMeta($dom)
//     {
//         try {
//             $head = $dom->getElementsByTagName('head');

//             if ($head && $head->length > 0) {
//                 $headElement = $head->item(0);

//                 $existingMeta = $dom->getElementsByTagName('meta');
//                 $hasCharset = false;

//                 foreach ($existingMeta as $meta) {
//                     if ($meta->hasAttribute('charset')) {
//                         $hasCharset = true;
//                         break;
//                     }
//                 }

//                 if (!$hasCharset) {
//                     $meta = $dom->createElement('meta');
//                     $meta->setAttribute('charset', 'UTF-8');
//                     $headElement->insertBefore($meta, $headElement->firstChild);
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::warning('Failed to add charset meta: ' . $e->getMessage());
//         }
//     }
// }








// seconed version dosn't support JavaScript-heavy websites (SPAs) and focuses on regular HTML pages.

// namespace App\Services;
// use DOMDocument;
// use DOMXPath;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Log;

// class CompleteWebScraperService
// {
//     private $baseUrl;
//     private $downloadedAssets = [];
//     private $assetPath = 'scraped-assets';

//     public function scrapeCompleteWebsite($url, $customHtml = null)
//     {
//         try {
//             // التحقق من صحة الـ URL
//             if (!filter_var($url, FILTER_VALIDATE_URL)) {
//                 throw new \Exception('Invalid URL provided');
//             }

//             // استخراج الـ base URL
//             $this->baseUrl = $this->getBaseUrl($url);

//             $html = '';

//             // إذا كان فيه custom HTML (للـ SPA)، استخدمه
//             if (!empty($customHtml)) {
//                 $html = $customHtml;
//                 Log::info('Using custom HTML for SPA processing');
//             } else {
//                 // جلب الـ HTML الأساسي للمواقع العادية
//                 $response = Http::timeout(30)
//                     ->withHeaders([
//                         'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
//                     ])
//                     ->get($url);

//                 if (!$response->successful()) {
//                     throw new \Exception('Failed to fetch the website. HTTP Status: ' . $response->status());
//                 }

//                 $html = $response->body();
//             }

//             if (empty($html)) {
//                 throw new \Exception('Empty HTML content received');
//             }

//             // معالجة الـ HTML وتحميل الأصول
//             $processedHtml = $this->processHtml($html, $url, !empty($customHtml));

//             return [
//                 'html' => $processedHtml,
//                 'assets' => $this->downloadedAssets,
//                 'status' => 'success',
//                 'is_spa_mode' => !empty($customHtml)
//             ];

//         } catch (\Exception $e) {
//             Log::error('Web scraping failed: ' . $e->getMessage(), [
//                 'url' => $url ?? 'unknown',
//                 'is_custom_html' => !empty($customHtml),
//                 'trace' => $e->getTraceAsString()
//             ]);

//             return [
//                 'html' => null,
//                 'assets' => [],
//                 'status' => 'error',
//                 'message' => $e->getMessage(),
//                 'is_spa_mode' => !empty($customHtml)
//             ];
//         }
//     }

//     private function removeJavaScript($dom)
//     {
//         try {
//             // إزالة جميع عناصر script
//             $scriptElements = $dom->getElementsByTagName('script');
//             $scriptsToRemove = [];

//             foreach ($scriptElements as $script) {
//                 $scriptsToRemove[] = $script;
//             }

//             foreach ($scriptsToRemove as $script) {
//                 if ($script->parentNode) {
//                     $script->parentNode->removeChild($script);
//                 }
//             }

//             // إزالة event handlers من العناصر
//             $xpath = new DOMXPath($dom);
//             $elementsWithEvents = $xpath->query('//*[@onclick or @onload or @onmouseover or @onmouseout or @onfocus or @onblur or @onchange or @onsubmit]');

//             if ($elementsWithEvents) {
//                 foreach ($elementsWithEvents as $element) {
//                     $attributes = [];
//                     for ($i = 0; $i < $element->attributes->length; $i++) {
//                         $attr = $element->attributes->item($i);
//                         if (strpos($attr->name, 'on') === 0) {
//                             $attributes[] = $attr->name;
//                         }
//                     }

//                     foreach ($attributes as $attrName) {
//                         $element->removeAttribute($attrName);
//                     }
//                 }
//             }

//             Log::info('JavaScript removed successfully');

//         } catch (\Exception $e) {
//             Log::warning('Failed to remove JavaScript: ' . $e->getMessage());
//         }
//     }


//     // تعديل دالة processHtml لتشمل إزالة JavaScript
//     private function processHtml($html, $originalUrl, $isSpaMode = false)
//     {
//         try {
//             $dom = new DOMDocument();
//             libxml_use_internal_errors(true);

//             // تحسين تحميل الـ HTML
//             $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

//             // للـ SPA: التأكد من وجود هيكل HTML صحيح
//             if ($isSpaMode) {
//                 $html = $this->ensureValidHtmlStructure($html);
//             } else {
//                 // للمواقع العادية: إضافة هيكل HTML إذا لم يكن موجود
//                 if (!preg_match('/<html[^>]*>/i', $html)) {
//                     $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $html . '</body></html>';
//                 } else if (!preg_match('/<body[^>]*>/i', $html)) {
//                     $html = preg_replace('/(<html[^>]*>)/i', '$1<head><meta charset="UTF-8"></head><body>', $html);
//                     $html .= '</body>';
//                 }
//             }

//             $success = $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

//             if (!$success) {
//                 throw new \Exception('Failed to parse HTML document');
//             }

//             libxml_clear_errors();
//             $xpath = new DOMXPath($dom);

//             if (!$xpath) {
//                 throw new \Exception('Failed to create XPath object');
//             }

//             // إزالة JavaScript أولاً قبل معالجة الأصول
//             $this->removeJavaScript($dom);

//             // معالجة الأصول بنفس الطريقة للمواقع العادية والـ SPA
//             $this->processCssFiles($xpath, $dom);
//             $this->processInlineStyles($xpath, $dom);
//             $this->processImages($xpath, $dom);
//             // تعليق هذا السطر لتجنب تحميل JavaScript
//             // $this->processJavaScriptFiles($xpath, $dom);
//             $this->processFonts($xpath, $dom);
//             $this->addCharsetMeta($dom);

//             // للـ SPA: إضافة تعليق للتوضيح
//             if ($isSpaMode) {
//                 $this->addSpaComment($dom);
//             }

//             $finalHtml = $dom->saveHTML();

//             // التأكد من الهيكل النهائي
//             if (!preg_match('/<html[^>]*>/i', $finalHtml)) {
//                 $finalHtml = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $finalHtml . '</body></html>';
//             }

//             return $finalHtml;

//         } catch (\Exception $e) {
//             Log::error('HTML processing failed: ' . $e->getMessage(), [
//                 'is_spa_mode' => $isSpaMode
//             ]);
//             throw new \Exception('Failed to process HTML: ' . $e->getMessage());
//         }
//     }

//     private function ensureValidHtmlStructure($html)
//     {
//         // إذا كان الـ HTML يحتوي على تاج html كامل، استخدمه كما هو
//         if (preg_match('/<html[^>]*>.*<\/html>/is', $html)) {
//             return $html;
//         }

//         // إذا كان يحتوي على body فقط، أضف head
//         if (preg_match('/<body[^>]*>/i', $html)) {
//             if (!preg_match('/<head[^>]*>/i', $html)) {
//                 $html = preg_replace('/(<body[^>]*>)/i', '<head><meta charset="UTF-8"></head>$1', $html);
//             }
//             if (!preg_match('/<html[^>]*>/i', $html)) {
//                 $html = '<!DOCTYPE html><html>' . $html . '</html>';
//             }
//             return $html;
//         }

//         // إذا كان محتوى body فقط، أضف الهيكل الكامل
//         return '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $html . '</body></html>';
//     }

//     private function addSpaComment($dom)
//     {
//         try {
//             $comment = $dom->createComment(' This content was extracted from a Single Page Application (SPA) ');
//             $body = $dom->getElementsByTagName('body');
//             if ($body && $body->length > 0) {
//                 $bodyElement = $body->item(0);
//                 $bodyElement->insertBefore($comment, $bodyElement->firstChild);
//             }
//         } catch (\Exception $e) {
//             Log::warning('Failed to add SPA comment: ' . $e->getMessage());
//         }
//     }

//     // باقي الدوال تبقى كما هي...
//     private function processCssFiles($xpath, $dom)
//     {
//         try {
//             $linkElements = $xpath->query('//link[@rel="stylesheet"][@href]');

//             if ($linkElements === false) {
//                 Log::warning('XPath query for CSS files failed');
//                 return;
//             }

//             foreach ($linkElements as $link) {
//                 try {
//                     $href = $link->getAttribute('href');

//                     if (empty($href)) {
//                         continue;
//                     }

//                     $absoluteUrl = $this->makeAbsoluteUrl($href);
//                     $cssContent = $this->downloadAsset($absoluteUrl, 'css');

//                     if ($cssContent) {
//                         $processedCss = $this->processCssContent($cssContent, $absoluteUrl);
//                         $localPath = $this->saveAsset($processedCss, 'css', $href);

//                         if ($localPath) {
//                             $link->setAttribute('href', $localPath);
//                         }
//                     }
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process CSS file: ' . $href . ' - ' . $e->getMessage());
//                     continue;
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('CSS processing failed: ' . $e->getMessage());
//         }
//     }

//     private function processInlineStyles($xpath, $dom)
//     {
//         try {
//             $styleElements = $xpath->query('//style');

//             if ($styleElements === false) {
//                 Log::warning('XPath query for inline styles failed');
//                 return;
//             }

//             foreach ($styleElements as $style) {
//                 try {
//                     $cssContent = $style->textContent;
//                     if (!empty($cssContent)) {
//                         $processedCss = $this->processCssContent($cssContent, $this->baseUrl);
//                         $style->textContent = $processedCss;
//                     }
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process inline style: ' . $e->getMessage());
//                     continue;
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('Inline styles processing failed: ' . $e->getMessage());
//         }
//     }

//     private function processCssContent($cssContent, $baseUrl)
//     {
//         if (empty($cssContent)) {
//             return $cssContent;
//         }

//         try {
//             $pattern = '/url\s*\(\s*[\'"]?([^\'"\)]+)[\'"]?\s*\)/i';

//             return preg_replace_callback($pattern, function ($matches) use ($baseUrl) {
//                 try {
//                     $url = trim($matches[1]);

//                     if (strpos($url, 'data:') === 0 || strpos($url, 'http') === 0) {
//                         return $matches[0];
//                     }

//                     $absoluteUrl = $this->makeAbsoluteUrl($url, $baseUrl);
//                     $localPath = $this->downloadAndSaveAsset($absoluteUrl);

//                     return $localPath ? "url('{$localPath}')" : $matches[0];
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process CSS URL: ' . ($url ?? 'unknown') . ' - ' . $e->getMessage());
//                     return $matches[0];
//                 }
//             }, $cssContent);
//         } catch (\Exception $e) {
//             Log::warning('CSS content processing failed: ' . $e->getMessage());
//             return $cssContent;
//         }
//     }

//     private function processImages($xpath, $dom)
//     {
//         try {
//             $imgElements = $xpath->query('//img[@src]');

//             if ($imgElements === false) {
//                 Log::warning('XPath query for images failed');
//                 return;
//             }

//             foreach ($imgElements as $img) {
//                 try {
//                     $src = $img->getAttribute('src');

//                     if (!empty($src) && strpos($src, 'data:') !== 0) {
//                         $absoluteUrl = $this->makeAbsoluteUrl($src);
//                         $localPath = $this->downloadAndSaveAsset($absoluteUrl);

//                         if ($localPath) {
//                             $img->setAttribute('src', $localPath);
//                         }
//                     }
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process image: ' . ($src ?? 'unknown') . ' - ' . $e->getMessage());
//                     continue;
//                 }
//             }

//             // معالجة background images في الـ style attributes
//             $elementsWithStyle = $xpath->query('//*[@style]');

//             if ($elementsWithStyle !== false) {
//                 foreach ($elementsWithStyle as $element) {
//                     try {
//                         $style = $element->getAttribute('style');
//                         if (!empty($style)) {
//                             $updatedStyle = $this->processCssContent($style, $this->baseUrl);
//                             $element->setAttribute('style', $updatedStyle);
//                         }
//                     } catch (\Exception $e) {
//                         Log::warning('Failed to process element style: ' . $e->getMessage());
//                         continue;
//                     }
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('Image processing failed: ' . $e->getMessage());
//         }
//     }

//     private function processJavaScriptFiles($xpath, $dom)
//     {
//         try {
//             $scriptElements = $xpath->query('//script[@src]');

//             if ($scriptElements === false) {
//                 Log::warning('XPath query for JavaScript files failed');
//                 return;
//             }

//             foreach ($scriptElements as $script) {
//                 try {
//                     $src = $script->getAttribute('src');

//                     if (!empty($src)) {
//                         $absoluteUrl = $this->makeAbsoluteUrl($src);
//                         $jsContent = $this->downloadAsset($absoluteUrl, 'js');

//                         if ($jsContent) {
//                             $localPath = $this->saveAsset($jsContent, 'js', $src);
//                             if ($localPath) {
//                                 $script->setAttribute('src', $localPath);
//                             }
//                         }
//                     }
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process JS file: ' . ($src ?? 'unknown') . ' - ' . $e->getMessage());
//                     continue;
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('JavaScript processing failed: ' . $e->getMessage());
//         }
//     }

//     private function processFonts($xpath, $dom)
//     {
//         try {
//             $linkElements = $xpath->query('//link[@href*="fonts.googleapis.com"] | //link[@href*="fonts.google.com"]');

//             if ($linkElements === false) {
//                 Log::warning('XPath query for fonts failed');
//                 return;
//             }

//             foreach ($linkElements as $link) {
//                 try {
//                     $href = $link->getAttribute('href');
//                     if (!empty($href)) {
//                         $cssContent = $this->downloadAsset($href, 'css');

//                         if ($cssContent) {
//                             $processedCss = $this->processCssContent($cssContent, $href);
//                             $localPath = $this->saveAsset($processedCss, 'css', $href);
//                             if ($localPath) {
//                                 $link->setAttribute('href', $localPath);
//                             }
//                         }
//                     }
//                 } catch (\Exception $e) {
//                     Log::warning('Failed to process font: ' . ($href ?? 'unknown') . ' - ' . $e->getMessage());
//                     continue;
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('Font processing failed: ' . $e->getMessage());
//         }
//     }

//     private function downloadAsset($url, $type = null)
//     {
//         try {
//             if (empty($url)) {
//                 return false;
//             }

//             $response = Http::timeout(15)
//                 ->withHeaders([
//                     'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
//                 ])
//                 ->get($url);

//             if ($response->successful() && !empty($response->body())) {
//                 return $response->body();
//             }

//             Log::warning("Asset download failed: {$url} - HTTP Status: " . $response->status());
//         } catch (\Exception $e) {
//             Log::warning("Failed to download asset: {$url} - " . $e->getMessage());
//         }

//         return false;
//     }

//     private function downloadAndSaveAsset($url)
//     {
//         $content = $this->downloadAsset($url);

//         if ($content !== false) {
//             return $this->saveAsset($content, null, $url);
//         }

//         return false;
//     }

//     private function saveAsset($content, $type = null, $originalUrl = null)
//     {
//         try {
//             if (empty($content)) {
//                 return false;
//             }

//             $filename = $this->generateFilename($originalUrl, $type, $content);
//             $publicPath = 'public/' . $this->assetPath . '/' . $filename;

//             if (!Storage::exists(dirname($publicPath))) {
//                 Storage::makeDirectory(dirname($publicPath));
//             }

//             Storage::put($publicPath, $content);
//             $assetUrl = asset('storage/' . $this->assetPath . '/' . $filename);

//             $this->downloadedAssets[] = [
//                 'original_url' => $originalUrl,
//                 'local_path' => $publicPath,
//                 'asset_url' => $assetUrl
//             ];

//             return $assetUrl;
//         } catch (\Exception $e) {
//             Log::error('Failed to save asset: ' . $e->getMessage(), [
//                 'original_url' => $originalUrl,
//                 'type' => $type
//             ]);
//             return false;
//         }
//     }

//     private function generateFilename($url, $type = null, $content = null)
//     {
//         $hash = md5(($url ?? 'unknown') . time() . rand());

//         if ($type) {
//             return $hash . '.' . $type;
//         }

//         $extension = '';

//         if ($url) {
//             $urlPath = parse_url($url, PHP_URL_PATH);
//             if ($urlPath) {
//                 $extension = pathinfo($urlPath, PATHINFO_EXTENSION);
//                 $extension = preg_replace('/\?.*$/', '', $extension);
//             }
//         }

//         if (empty($extension) && $content) {
//             $extension = $this->getExtensionFromContent($content);
//         }

//         if (empty($extension) && $url) {
//             $extension = $this->guessExtensionFromUrl($url);
//         }

//         if (empty($extension)) {
//             $extension = 'asset';
//         }

//         return $hash . '.' . $extension;
//     }

//     private function getExtensionFromContent($content)
//     {
//         $firstBytes = substr($content, 0, 20);

//         if (strpos($firstBytes, "\xFF\xD8\xFF") === 0) {
//             return 'jpg';
//         }

//         if (strpos($firstBytes, "\x89PNG\r\n\x1A\n") === 0) {
//             return 'png';
//         }

//         if (strpos($firstBytes, "GIF87a") === 0 || strpos($firstBytes, "GIF89a") === 0) {
//             return 'gif';
//         }

//         if (strpos($firstBytes, "RIFF") === 0 && strpos($firstBytes, "WEBP") !== false) {
//             return 'webp';
//         }

//         if (strpos($content, '<svg') !== false) {
//             return 'svg';
//         }

//         if (preg_match('/^\s*(@import|@charset|\/\*|[a-zA-Z#\.\-_].*\{)/m', $content)) {
//             return 'css';
//         }

//         if (preg_match('/(function\s*\(|var\s+|let\s+|const\s+|if\s*\(|for\s*\(|while\s*\()/m', $content)) {
//             return 'js';
//         }

//         if (strpos($firstBytes, "wOFF") === 0) {
//             return 'woff';
//         }
//         if (strpos($firstBytes, "wOF2") === 0) {
//             return 'woff2';
//         }

//         return '';
//     }

//     private function guessExtensionFromUrl($url)
//     {
//         if (strpos($url, 'image') !== false) {
//             if (strpos($url, 'jpeg') !== false || strpos($url, 'jpg') !== false) {
//                 return 'jpg';
//             }
//             if (strpos($url, 'png') !== false) {
//                 return 'png';
//             }
//             if (strpos($url, 'gif') !== false) {
//                 return 'gif';
//             }
//             if (strpos($url, 'webp') !== false) {
//                 return 'webp';
//             }
//             if (strpos($url, 'svg') !== false) {
//                 return 'svg';
//             }
//             return 'jpg';
//         }

//         if (strpos($url, 'font') !== false || strpos($url, 'woff') !== false) {
//             if (strpos($url, 'woff2') !== false) {
//                 return 'woff2';
//             }
//             return 'woff';
//         }

//         if (strpos($url, 'css') !== false || strpos($url, 'style') !== false) {
//             return 'css';
//         }

//         if (strpos($url, 'js') !== false || strpos($url, 'javascript') !== false) {
//             return 'js';
//         }

//         return '';
//     }

//     private function makeAbsoluteUrl($url, $baseUrl = null)
//     {
//         try {
//             if (empty($url)) {
//                 return '';
//             }

//             $baseUrl = $baseUrl ?? $this->baseUrl;

//             if (filter_var($url, FILTER_VALIDATE_URL)) {
//                 return $url;
//             }

//             if (strpos($url, '//') === 0) {
//                 return 'https:' . $url;
//             }

//             if (strpos($url, '/') === 0) {
//                 $parsedBase = parse_url($baseUrl);
//                 if ($parsedBase && isset($parsedBase['scheme']) && isset($parsedBase['host'])) {
//                     return $parsedBase['scheme'] . '://' . $parsedBase['host'] . $url;
//                 }
//             }

//             return rtrim($baseUrl, '/') . '/' . ltrim($url, '/');
//         } catch (\Exception $e) {
//             Log::warning('Failed to make absolute URL: ' . $e->getMessage(), [
//                 'url' => $url,
//                 'baseUrl' => $baseUrl
//             ]);
//             return $url;
//         }
//     }

//     private function getBaseUrl($url)
//     {
//         try {
//             $parsed = parse_url($url);
//             if ($parsed && isset($parsed['scheme']) && isset($parsed['host'])) {
//                 return $parsed['scheme'] . '://' . $parsed['host'];
//             }
//             throw new \Exception('Invalid URL structure');
//         } catch (\Exception $e) {
//             Log::error('Failed to get base URL: ' . $e->getMessage(), ['url' => $url]);
//             throw new \Exception('Invalid URL provided');
//         }
//     }

//     private function addCharsetMeta($dom)
//     {
//         try {
//             $head = $dom->getElementsByTagName('head');

//             if ($head && $head->length > 0) {
//                 $headElement = $head->item(0);

//                 $existingMeta = $dom->getElementsByTagName('meta');
//                 $hasCharset = false;

//                 foreach ($existingMeta as $meta) {
//                     if ($meta->hasAttribute('charset')) {
//                         $hasCharset = true;
//                         break;
//                     }
//                 }

//                 if (!$hasCharset) {
//                     $meta = $dom->createElement('meta');
//                     $meta->setAttribute('charset', 'UTF-8');
//                     $headElement->insertBefore($meta, $headElement->firstChild);
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::warning('Failed to add charset meta: ' . $e->getMessage());
//         }
//     }
// }









// // This version supports JavaScript-heavy websites (SPAs) and regular HTML pages.
// HTTP Client يحمل الصفحة
// DOMDocument يحلل HTML
// XPath يبحث عن العناصر المطلوبة
// RegEx يستخرج الروابط من CSS
// parse_url يحول الروابط النسبية لمطلقة
// HTTP Client يحمل كل ملف
// File Detection يحدد نوع كل ملف
// Storage يحفظ الملفات
// DOMDocument يحدث الروابط في HTML

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CompleteWebScraperService
{
    private $baseUrl;
    private $downloadedAssets = [];
    private $assetPath = 'scraped-assets';

    // default download options
    private $downloadOptions = [
        'css' => true,
        'images' => true,
        'js' => true,
        'fonts' => true,
        'json' => true,
        'other_assets' => true
    ];

    public function scrapeCompleteWebsite($url, $customHtml = null, $downloadOptions = [])
    {
        try {
            // merge the provided download options with the default ones
            $this->downloadOptions = array_merge($this->downloadOptions, $downloadOptions);

            Log::info('Starting website scraping with options', [
                'url' => $url,
                'download_options' => $this->downloadOptions,
                'is_spa' => !empty($customHtml)
            ]);

            // check if the URL is valid
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                throw new \Exception('Invalid URL provided');
            }

            $this->baseUrl = $this->getBaseUrl($url);

            $html = '';

            // if there is custom HTML (for SPA), use it
            if (!empty($customHtml)) {
                $html = $customHtml;
                Log::info('Using custom HTML for SPA processing');
            } else {
                // get the main HTML for regular websites
                $response = Http::timeout(30)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                        'Accept-Language' => 'en-US,en;q=0.5',
                        'Accept-Encoding' => 'gzip, deflate',
                        'Connection' => 'keep-alive',
                        'Upgrade-Insecure-Requests' => '1'
                    ])
                    ->get($url);

                if (!$response->successful()) {
                    throw new \Exception('Failed to fetch the website. HTTP Status: ' . $response->status());
                }

                $html = $response->body();
            }

            if (empty($html)) {
                throw new \Exception('Empty HTML content received');
            }

            $processedHtml = $this->processHtml($html, $url, !empty($customHtml));

            Log::info('Website scraping completed', [
                'assets_downloaded' => count($this->downloadedAssets),
                'download_options' => $this->downloadOptions
            ]);

            return [
                'html' => $processedHtml,
                'assets' => $this->downloadedAssets,
                'status' => 'success',
                'is_spa_mode' => !empty($customHtml),
                'download_options' => $this->downloadOptions
            ];
        } catch (\Exception $e) {
            Log::error('Web scraping failed: ' . $e->getMessage(), [
                'url' => $url ?? 'unknown',
                'is_custom_html' => !empty($customHtml),
                'download_options' => $this->downloadOptions,
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'html' => null,
                'assets' => [],
                'status' => 'error',
                'message' => $e->getMessage(),
                'is_spa_mode' => !empty($customHtml),
                'download_options' => $this->downloadOptions
            ];
        }
    }

    private function processHtml($html, $originalUrl, $isSpaMode = false)
    {
        try {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);

            // تحسين تحميل الـ HTML
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

            // للـ SPA: التأكد من وجود هيكل HTML صحيح
            if ($isSpaMode) {
                $html = $this->ensureValidHtmlStructure($html);
            } else {
                // للمواقع العادية: إضافة هيكل HTML إذا لم يكن موجود
                if (!preg_match('/<html[^>]*>/i', $html)) {
                    $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $html . '</body></html>';
                } else if (!preg_match('/<body[^>]*>/i', $html)) {
                    $html = preg_replace('/(<html[^>]*>)/i', '$1<head><meta charset="UTF-8"></head><body>', $html);
                    $html .= '</body>';
                }
            }

            $success = $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            if (!$success) {
                throw new \Exception('Failed to parse HTML document');
            }

            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            if (!$xpath) {
                throw new \Exception('Failed to create XPath object');
            }

            // معالجة الأصول حسب الخيارات المحددة أولاً
            if ($this->downloadOptions['css']) {
                $this->processCssFiles($xpath, $dom);
                $this->processInlineStyles($xpath, $dom);
            } else {
                Log::info('CSS files download skipped as per user preference');
            }

            if ($this->downloadOptions['images']) {
                $this->processImages($xpath, $dom);
            } else {
                Log::info('Images download skipped as per user preference');
            }

            if ($this->downloadOptions['fonts']) {
                $this->processFonts($xpath, $dom);
            } else {
                Log::info('Font files download skipped as per user preference');
            }

            // إزالة JavaScript بعد معالجة الأصول (لأن بعض الـ JS قد يحتوي على URLs للأصول)
            if (!$this->downloadOptions['js']) {
                $this->removeJavaScript($dom);
            } else {
                $this->processJavaScriptFiles($xpath, $dom);
            }

            $this->addCharsetMeta($dom);

            // للـ SPA: إضافة تعليق للتوضيح
            if ($isSpaMode) {
                $this->addSpaComment($dom);
            }

            $finalHtml = $dom->saveHTML();

            // التأكد من الهيكل النهائي
            if (!preg_match('/<html[^>]*>/i', $finalHtml)) {
                $finalHtml = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $finalHtml . '</body></html>';
            }

            return $finalHtml;
        } catch (\Exception $e) {
            Log::error('HTML processing failed: ' . $e->getMessage(), [
                'is_spa_mode' => $isSpaMode,
                'download_options' => $this->downloadOptions
            ]);
            throw new \Exception('Failed to process HTML: ' . $e->getMessage());
        }
    }

    private function removeJavaScript($dom)
    {
        try {
            // إزالة جميع عناصر script
            $scriptElements = $dom->getElementsByTagName('script');
            $scriptsToRemove = [];

            foreach ($scriptElements as $script) {
                $scriptsToRemove[] = $script;
            }

            foreach ($scriptsToRemove as $script) {
                if ($script->parentNode) {
                    $script->parentNode->removeChild($script);
                }
            }

            // إزالة event handlers من العناصر
            $xpath = new DOMXPath($dom);
            $elementsWithEvents = $xpath->query('//*[@onclick or @onload or @onmouseover or @onmouseout or @onfocus or @onblur or @onchange or @onsubmit]');

            if ($elementsWithEvents) {
                foreach ($elementsWithEvents as $element) {
                    $attributes = [];
                    for ($i = 0; $i < $element->attributes->length; $i++) {
                        $attr = $element->attributes->item($i);
                        if (strpos($attr->name, 'on') === 0) {
                            $attributes[] = $attr->name;
                        }
                    }

                    foreach ($attributes as $attrName) {
                        $element->removeAttribute($attrName);
                    }
                }
            }

            Log::info('JavaScript removed successfully');
        } catch (\Exception $e) {
            Log::warning('Failed to remove JavaScript: ' . $e->getMessage());
        }
    }

    private function ensureValidHtmlStructure($html)
    {
        // إذا كان الـ HTML يحتوي على تاج html كامل، استخدمه كما هو
        if (preg_match('/<html[^>]*>.*<\/html>/is', $html)) {
            return $html;
        }

        // إذا كان يحتوي على body فقط، أضف head
        if (preg_match('/<body[^>]*>/i', $html)) {
            if (!preg_match('/<head[^>]*>/i', $html)) {
                $html = preg_replace('/(<body[^>]*>)/i', '<head><meta charset="UTF-8"></head>$1', $html);
            }
            if (!preg_match('/<html[^>]*>/i', $html)) {
                $html = '<!DOCTYPE html><html>' . $html . '</html>';
            }
            return $html;
        }

        // إذا كان محتوى body فقط، أضف الهيكل الكامل
        return '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $html . '</body></html>';
    }

    private function addSpaComment($dom)
    {
        try {
            $comment = $dom->createComment(' This content was extracted from a Single Page Application (SPA) ');
            $body = $dom->getElementsByTagName('body');
            if ($body && $body->length > 0) {
                $bodyElement = $body->item(0);
                $bodyElement->insertBefore($comment, $bodyElement->firstChild);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to add SPA comment: ' . $e->getMessage());
        }
    }

    private function processCssFiles($xpath, $dom)
    {
        try {
            $linkElements = $xpath->query('//link[@rel="stylesheet"][@href]');

            if ($linkElements === false) {
                Log::warning('XPath query for CSS files failed');
                return;
            }

            Log::info('Found CSS files', ['count' => $linkElements->length]);

            foreach ($linkElements as $link) {
                try {
                    $href = trim($link->getAttribute('href'));

                    if (empty($href) || strpos($href, 'data:') === 0) {
                        continue;
                    }

                    Log::info('Processing CSS file', ['href' => $href]);

                    $absoluteUrl = $this->makeAbsoluteUrl($href);
                    Log::info('Absolute URL for CSS', ['absolute_url' => $absoluteUrl]);

                    $cssContent = $this->downloadAsset($absoluteUrl, 'css');

                    if ($cssContent !== false) {
                        Log::info('CSS content downloaded successfully', [
                            'url' => $absoluteUrl,
                            'size' => strlen($cssContent)
                        ]);

                        $processedCss = $this->processCssContent($cssContent, $absoluteUrl);
                        $localPath = $this->saveAsset($processedCss, 'css', $href);

                        if ($localPath) {
                            $link->setAttribute('href', $localPath);
                            Log::info('CSS file processed and saved', [
                                'original' => $href,
                                'local_path' => $localPath
                            ]);
                        }
                    } else {
                        Log::warning('Failed to download CSS content', ['url' => $absoluteUrl]);
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to process CSS file', [
                        'href' => $href ?? 'unknown',
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }
        } catch (\Exception $e) {
            Log::error('CSS processing failed: ' . $e->getMessage());
        }
    }

    private function processInlineStyles($xpath, $dom)
    {
        try {
            $styleElements = $xpath->query('//style');

            if ($styleElements === false) {
                Log::warning('XPath query for inline styles failed');
                return;
            }

            Log::info('Found inline styles', ['count' => $styleElements->length]);

            foreach ($styleElements as $style) {
                try {
                    $cssContent = $style->textContent;
                    if (!empty($cssContent)) {
                        $processedCss = $this->processCssContent($cssContent, $this->baseUrl);
                        $style->textContent = $processedCss;
                        Log::info('Inline style processed successfully');
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to process inline style: ' . $e->getMessage());
                    continue;
                }
            }
        } catch (\Exception $e) {
            Log::error('Inline styles processing failed: ' . $e->getMessage());
        }
    }

    private function processCssContent($cssContent, $baseUrl)
    {
        if (empty($cssContent)) {
            return $cssContent;
        }

        try {
            $pattern = '/url\s*\(\s*[\'"]?([^\'"\)]+)[\'"]?\s*\)/i';

            return preg_replace_callback($pattern, function ($matches) use ($baseUrl) {
                try {
                    $url = trim($matches[1]);

                    // تجاهل data URLs والـ URLs المطلقة
                    if (strpos($url, 'data:') === 0) {
                        return $matches[0];
                    }

                    $absoluteUrl = $this->makeAbsoluteUrl($url, $baseUrl);
                    Log::info('Processing CSS URL', [
                        'original' => $url,
                        'absolute' => $absoluteUrl
                    ]);

                    // التحقق من نوع الملف وخيارات التحميل
                    $fileType = $this->getAssetType($absoluteUrl);

                    if (!$this->shouldDownloadAsset($fileType)) {
                        Log::info("Skipping asset download based on user preferences", [
                            'url' => $absoluteUrl,
                            'type' => $fileType
                        ]);
                        return $matches[0];
                    }

                    $localPath = $this->downloadAndSaveAsset($absoluteUrl);

                    if ($localPath) {
                        Log::info('CSS asset downloaded and saved', [
                            'original' => $url,
                            'local_path' => $localPath
                        ]);
                        return "url('{$localPath}')";
                    }

                    return $matches[0];
                } catch (\Exception $e) {
                    Log::warning('Failed to process CSS URL', [
                        'url' => $url ?? 'unknown',
                        'error' => $e->getMessage()
                    ]);
                    return $matches[0];
                }
            }, $cssContent);
        } catch (\Exception $e) {
            Log::warning('CSS content processing failed: ' . $e->getMessage());
            return $cssContent;
        }
    }

    private function processImages($xpath, $dom)
    {
        try {
            $imgElements = $xpath->query('//img[@src]');

            if ($imgElements === false) {
                Log::warning('XPath query for images failed');
                return;
            }

            Log::info('Found images', ['count' => $imgElements->length]);

            foreach ($imgElements as $img) {
                try {
                    $src = trim($img->getAttribute('src'));

                    if (empty($src) || strpos($src, 'data:') === 0) {
                        continue;
                    }

                    Log::info('Processing image', ['src' => $src]);

                    $absoluteUrl = $this->makeAbsoluteUrl($src);
                    $localPath = $this->downloadAndSaveAsset($absoluteUrl);

                    if ($localPath) {
                        $img->setAttribute('src', $localPath);
                        Log::info('Image processed and saved', [
                            'original' => $src,
                            'local_path' => $localPath
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to process image', [
                        'src' => $src ?? 'unknown',
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }

            // معالجة background images في الـ style attributes
            $elementsWithStyle = $xpath->query('//*[@style]');

            if ($elementsWithStyle !== false) {
                Log::info('Found elements with style attributes', ['count' => $elementsWithStyle->length]);

                foreach ($elementsWithStyle as $element) {
                    try {
                        $style = $element->getAttribute('style');
                        if (!empty($style)) {
                            $updatedStyle = $this->processCssContent($style, $this->baseUrl);
                            $element->setAttribute('style', $updatedStyle);
                        }
                    } catch (\Exception $e) {
                        Log::warning('Failed to process element style: ' . $e->getMessage());
                        continue;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Image processing failed: ' . $e->getMessage());
        }
    }

    private function processJavaScriptFiles($xpath, $dom)
    {
        try {
            $scriptElements = $xpath->query('//script[@src]');

            if ($scriptElements === false) {
                Log::warning('XPath query for JavaScript files failed');
                return;
            }

            Log::info('Found JavaScript files', ['count' => $scriptElements->length]);

            foreach ($scriptElements as $script) {
                try {
                    $src = trim($script->getAttribute('src'));

                    if (empty($src)) {
                        continue;
                    }

                    Log::info('Processing JS file', ['src' => $src]);

                    $absoluteUrl = $this->makeAbsoluteUrl($src);
                    $fileType = $this->getAssetType($absoluteUrl);

                    if (!$this->shouldDownloadAsset($fileType)) {
                        Log::info("Skipping JS asset download based on user preferences", [
                            'url' => $absoluteUrl,
                            'type' => $fileType
                        ]);
                        continue;
                    }

                    $jsContent = $this->downloadAsset($absoluteUrl, 'js');

                    if ($jsContent !== false) {
                        $localPath = $this->saveAsset($jsContent, 'js', $src);
                        if ($localPath) {
                            $script->setAttribute('src', $localPath);
                            Log::info('JS file processed and saved', [
                                'original' => $src,
                                'local_path' => $localPath
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to process JS file', [
                        'src' => $src ?? 'unknown',
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }
        } catch (\Exception $e) {
            Log::error('JavaScript processing failed: ' . $e->getMessage());
        }
    }

    private function processFonts($xpath, $dom)
    {
        try {
            // معالجة روابط Google Fonts
            $fontLinks = $xpath->query('//link[@href*="fonts.googleapis.com"] | //link[@href*="fonts.google.com"] | //link[@href*="font"]');

            if ($fontLinks === false) {
                Log::warning('XPath query for fonts failed');
                return;
            }

            Log::info('Found font links', ['count' => $fontLinks->length]);

            foreach ($fontLinks as $link) {
                try {
                    $href = trim($link->getAttribute('href'));
                    if (empty($href)) {
                        continue;
                    }

                    Log::info('Processing font link', ['href' => $href]);

                    $cssContent = $this->downloadAsset($href, 'css');

                    if ($cssContent !== false) {
                        $processedCss = $this->processCssContent($cssContent, $href);
                        $localPath = $this->saveAsset($processedCss, 'css', $href);
                        if ($localPath) {
                            $link->setAttribute('href', $localPath);
                            Log::info('Font CSS processed and saved', [
                                'original' => $href,
                                'local_path' => $localPath
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to process font', [
                        'href' => $href ?? 'unknown',
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }
        } catch (\Exception $e) {
            Log::error('Font processing failed: ' . $e->getMessage());
        }
    }

    // دالة محسنة لتحديد نوع الملف
    private function getAssetType($url)
    {
        $urlPath = strtolower(parse_url($url, PHP_URL_PATH) ?? '');
        $queryString = strtolower(parse_url($url, PHP_URL_QUERY) ?? '');

        // التحقق من الامتدادات في المسار
        if (preg_match('/\.json(\?|$)/', $urlPath) || strpos($queryString, 'json') !== false) {
            return 'json';
        }

        if (preg_match('/\.js(\?|$)/', $urlPath) || strpos($url, 'javascript') !== false) {
            return 'js';
        }

        if (preg_match('/\.css(\?|$)/', $urlPath) || strpos($url, 'stylesheet') !== false) {
            return 'css';
        }

        if (preg_match('/\.(jpg|jpeg|png|gif|webp|svg)(\?|$)/', $urlPath)) {
            return 'images';
        }

        if (
            preg_match('/\.(woff|woff2|ttf|eot)(\?|$)/', $urlPath) ||
            strpos($url, 'font') !== false ||
            strpos($url, 'googleapis.com/css') !== false
        ) {
            return 'fonts';
        }

        return 'other_assets';
    }

    // دالة محسنة للتحقق من إمكانية تحميل نوع معين من الملفات
    private function shouldDownloadAsset($assetType)
    {
        $shouldDownload = isset($this->downloadOptions[$assetType]) ?
            $this->downloadOptions[$assetType] :
            $this->downloadOptions['other_assets'];

        Log::debug('Asset download decision', [
            'asset_type' => $assetType,
            'should_download' => $shouldDownload,
            'download_options' => $this->downloadOptions
        ]);

        return $shouldDownload;
    }

    private function downloadAsset($url, $type = null)
    {
        try {
            if (empty($url)) {
                return false;
            }

            Log::info('Attempting to download asset', ['url' => $url, 'type' => $type]);

            $response = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                    'Accept' => '*/*',
                    'Accept-Language' => 'en-US,en;q=0.9',
                    'Accept-Encoding' => 'gzip, deflate',
                    'Connection' => 'keep-alive',
                    'Referer' => $this->baseUrl
                ])
                ->get($url);

            if ($response->successful() && !empty($response->body())) {
                Log::info('Asset downloaded successfully', [
                    'url' => $url,
                    'size' => strlen($response->body()),
                    'status' => $response->status()
                ]);
                return $response->body();
            }

            Log::warning("Asset download failed", [
                'url' => $url,
                'status' => $response->status(),
                'headers' => $response->headers()
            ]);
        } catch (\Exception $e) {
            Log::warning("Failed to download asset", [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
        }

        return false;
    }

    private function downloadAndSaveAsset($url)
    {
        $content = $this->downloadAsset($url);

        if ($content !== false) {
            return $this->saveAsset($content, null, $url);
        }

        return false;
    }

    private function saveAsset($content, $type = null, $originalUrl = null)
    {
        try {
            if (empty($content)) {
                Log::warning('Attempt to save empty content', ['original_url' => $originalUrl]);
                return false;
            }

            $filename = $this->generateFilename($originalUrl, $type, $content);
            $publicPath = 'public/' . $this->assetPath . '/' . $filename;

            // إنشاء المجلدات إذا لم تكن موجودة
            $directory = dirname($publicPath);
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
                Log::info('Created directory', ['directory' => $directory]);
            }

            Storage::put($publicPath, $content);
            $assetUrl = asset('storage/' . $this->assetPath . '/' . $filename);

            $assetInfo = [
                'original_url' => $originalUrl,
                'local_path' => $publicPath,
                'asset_url' => $assetUrl,
                'type' => $type ?: $this->getAssetType($originalUrl ?? ''),
                'size' => strlen($content)
            ];

            $this->downloadedAssets[] = $assetInfo;

            Log::info('Asset saved successfully', $assetInfo);

            return $assetUrl;
        } catch (\Exception $e) {
            Log::error('Failed to save asset', [
                'original_url' => $originalUrl,
                'type' => $type,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    private function generateFilename($url, $type = null, $content = null)
    {
        $hash = md5(($url ?? 'unknown') . microtime(true) . rand());

        if ($type) {
            return $hash . '.' . $type;
        }

        $extension = '';

        // محاولة استخراج الامتداد من الـ URL
        if ($url) {
            $urlPath = parse_url($url, PHP_URL_PATH);
            if ($urlPath) {
                $pathExtension = pathinfo($urlPath, PATHINFO_EXTENSION);
                $pathExtension = preg_replace('/\?.*$/', '', $pathExtension);
                if (!empty($pathExtension) && strlen($pathExtension) <= 4) {
                    $extension = $pathExtension;
                }
            }
        }

        // محاولة استخراج الامتداد من المحتوى
        if (empty($extension) && $content) {
            $extension = $this->getExtensionFromContent($content);
        }

        // محاولة التخمين من الـ URL
        if (empty($extension) && $url) {
            $extension = $this->guessExtensionFromUrl($url);
        }

        // امتداد افتراضي
        if (empty($extension)) {
            $extension = 'asset';
        }

        return $hash . '.' . $extension;
    }

    private function getExtensionFromContent($content)
    {
        $firstBytes = substr($content, 0, 20);

        if (strpos($firstBytes, "\xFF\xD8\xFF") === 0) {
            return 'jpg';
        }

        if (strpos($firstBytes, "\x89PNG\r\n\x1A\n") === 0) {
            return 'png';
        }

        if (strpos($firstBytes, "GIF87a") === 0 || strpos($firstBytes, "GIF89a") === 0) {
            return 'gif';
        }

        if (strpos($firstBytes, "RIFF") === 0 && strpos($firstBytes, "WEBP") !== false) {
            return 'webp';
        }

        if (strpos($content, '<svg') !== false) {
            return 'svg';
        }

        if (preg_match('/^\s*(@import|@charset|\/\*|[a-zA-Z#\.\-_].*\{)/m', $content)) {
            return 'css';
        }

        if (preg_match('/(function\s*\(|var\s+|let\s+|const\s+|if\s*\(|for\s*\(|while\s*\()/m', $content)) {
            return 'js';
        }

        if (strpos($firstBytes, "wOFF") === 0) {
            return 'woff';
        }
        if (strpos($firstBytes, "wOF2") === 0) {
            return 'woff2';
        }

        return '';
    }

    private function guessExtensionFromUrl($url)
    {
        if (strpos($url, 'image') !== false) {
            if (strpos($url, 'jpeg') !== false || strpos($url, 'jpg') !== false) {
                return 'jpg';
            }
            if (strpos($url, 'png') !== false) {
                return 'png';
            }
            if (strpos($url, 'gif') !== false) {
                return 'gif';
            }
            if (strpos($url, 'webp') !== false) {
                return 'webp';
            }
            if (strpos($url, 'svg') !== false) {
                return 'svg';
            }
            return 'jpg';
        }

        if (strpos($url, 'font') !== false || strpos($url, 'woff') !== false) {
            if (strpos($url, 'woff2') !== false) {
                return 'woff2';
            }
            return 'woff';
        }

        if (strpos($url, 'css') !== false || strpos($url, 'style') !== false) {
            return 'css';
        }

        if (strpos($url, 'js') !== false || strpos($url, 'javascript') !== false) {
            return 'js';
        }

        return '';
    }

    private function makeAbsoluteUrl($url, $baseUrl = null)
    {
        try {
            if (empty($url)) {
                return '';
            }

            $baseUrl = $baseUrl ?? $this->baseUrl;

            if (filter_var($url, FILTER_VALIDATE_URL)) {
                return $url;
            }

            if (strpos($url, '//') === 0) {
                return 'https:' . $url;
            }

            if (strpos($url, '/') === 0) {
                $parsedBase = parse_url($baseUrl);
                if ($parsedBase && isset($parsedBase['scheme']) && isset($parsedBase['host'])) {
                    return $parsedBase['scheme'] . '://' . $parsedBase['host'] . $url;
                }
            }

            return rtrim($baseUrl, '/') . '/' . ltrim($url, '/');
        } catch (\Exception $e) {
            Log::warning('Failed to make absolute URL: ' . $e->getMessage(), [
                'url' => $url,
                'baseUrl' => $baseUrl
            ]);
            return $url;
        }
    }

    private function getBaseUrl($url)
    {
        try {
            $parsed = parse_url($url);
            if ($parsed && isset($parsed['scheme']) && isset($parsed['host'])) {
                return $parsed['scheme'] . '://' . $parsed['host'];
            }
            throw new \Exception('Invalid URL structure');
        } catch (\Exception $e) {
            Log::error('Failed to get base URL: ' . $e->getMessage(), ['url' => $url]);
            throw new \Exception('Invalid URL provided');
        }
    }

    private function addCharsetMeta($dom)
    {
        try {
            $head = $dom->getElementsByTagName('head');

            if ($head && $head->length > 0) {
                $headElement = $head->item(0);

                $existingMeta = $dom->getElementsByTagName('meta');
                $hasCharset = false;

                foreach ($existingMeta as $meta) {
                    if ($meta->hasAttribute('charset')) {
                        $hasCharset = true;
                        break;
                    }
                }

                if (!$hasCharset) {
                    $meta = $dom->createElement('meta');
                    $meta->setAttribute('charset', 'UTF-8');
                    $headElement->insertBefore($meta, $headElement->firstChild);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to add charset meta: ' . $e->getMessage());
        }
    }
}
