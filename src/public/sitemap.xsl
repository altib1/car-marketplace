<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" 
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
                xmlns:xhtml="http://www.w3.org/1999/xhtml">
  <xsl:output method="html" encoding="UTF-8" indent="yes"/>
  
  <xsl:template match="/">
    <html>
      <head>
        <title>XML Sitemap</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
          }
          h1 {
            color: #0066cc;
            font-size: 24px;
            margin-bottom: 20px;
          }
          table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
          }
          th {
            background-color: #4CAF50;
            color: white;
            text-align: left;
            padding: 12px;
            font-weight: bold;
          }
          td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
          }
          tr:hover {
            background-color: #f9f9f9;
          }
          .url-container {
            word-break: break-all;
          }
          .image-container {
            margin-top: 5px;
            border-top: 1px dashed #ddd;
            padding-top: 5px;
          }
          .hreflang-container {
            margin-top: 5px;
            border-top: 1px dashed #ddd;
            padding-top: 5px;
          }
          .badge {
            display: inline-block;
            padding: 3px 7px;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            background-color: #777;
            border-radius: 10px;
            margin-right: 5px;
          }
          .priority-high { background-color: #e53935; }
          .priority-medium { background-color: #fb8c00; }
          .priority-low { background-color: #43a047; }
        </style>
      </head>
      <body>
        <h1>XML Sitemap</h1>
        <table>
          <tr>
            <th>URL</th>
            <th>Last Modified</th>
            <th>Change Frequency</th>
            <th>Priority</th>
          </tr>
          <xsl:for-each select="sitemap:urlset/sitemap:url">
            <tr>
              <td class="url-container">
                <a href="{sitemap:loc}"><xsl:value-of select="sitemap:loc"/></a>
                
                <!-- Hreflang entries -->
                <xsl:if test="xhtml:link">
                  <div class="hreflang-container">
                    <strong>Alternative Languages:</strong>
                    <xsl:for-each select="xhtml:link">
                      <span class="badge"><xsl:value-of select="@hreflang"/></span>
                    </xsl:for-each>
                  </div>
                </xsl:if>
                
                <!-- Images -->
                <xsl:if test="image:image">
                  <div class="image-container">
                    <strong>Images (<xsl:value-of select="count(image:image)"/>):</strong>
                    <xsl:for-each select="image:image">
                      <div>
                        <small><xsl:value-of select="image:title"/></small>
                      </div>
                    </xsl:for-each>
                  </div>
                </xsl:if>
              </td>
              <td><xsl:value-of select="sitemap:lastmod"/></td>
              <td><xsl:value-of select="sitemap:changefreq"/></td>
              <td>
                <xsl:variable name="priority" select="sitemap:priority"/>
                <xsl:choose>
                  <xsl:when test="$priority > 0.7">
                    <span class="badge priority-high"><xsl:value-of select="$priority"/></span>
                  </xsl:when>
                  <xsl:when test="$priority > 0.4">
                    <span class="badge priority-medium"><xsl:value-of select="$priority"/></span>
                  </xsl:when>
                  <xsl:otherwise>
                    <span class="badge priority-low"><xsl:value-of select="$priority"/></span>
                  </xsl:otherwise>
                </xsl:choose>
              </td>
            </tr>
          </xsl:for-each>
        </table>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>