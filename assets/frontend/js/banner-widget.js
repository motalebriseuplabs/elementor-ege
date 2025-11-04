/**
 * Banner Widget JavaScript
 * Handles video popup functionality and interactions
 */

(function($) {
    'use strict';

    /**
     * Banner Widget Handler
     */
    class BannerWidget {
        constructor() {
            this.init();
        }

        init() {
            this.bindEvents();
        }

        bindEvents() {
            // Video click handler
            $(document).on('click', '.edge-banner__video', this.handleVideoClick.bind(this));

            // Play button click handler
            $(document).on('click', '.edge-banner__play-button', this.handlePlayButtonClick.bind(this));

            // Handle video modal close
            $(document).on('click', '.edge-video-modal-backdrop, .edge-video-modal-close', this.closeVideoModal.bind(this));

            // Handle escape key
            $(document).on('keydown', this.handledgescapeKey.bind(this));
        }

        handleVideoClick(e) {
            e.preventDefault();
            const videoContainer = $(e.currentTarget);
            const videoUrl = videoContainer.data('video-url');

            if (videoUrl) {
                this.openVideoModal(videoUrl);
            }
        }

        handlePlayButtonClick(e) {
            e.preventDefault();
            e.stopPropagation();

            const videoContainer = $(e.currentTarget).closest('.edge-banner__video');
            const videoUrl = videoContainer.data('video-url');

            if (videoUrl) {
                this.openVideoModal(videoUrl);
            }
        }

        openVideoModal(videoUrl) {
            const embedUrl = this.getEmbedUrl(videoUrl);

            if (!embedUrl) {
                console.warn('Unsupported video URL:', videoUrl);
                return;
            }

            const modalHtml = `
                <div class="edge-video-modal">
                    <div class="edge-video-modal-backdrop"></div>
                    <div class="edge-video-modal-content">
                        <button class="edge-video-modal-close" type="button">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div class="edge-video-modal-iframe-wrapper">
                            <iframe
                                src="${embedUrl}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscredgen>
                            </iframe>
                        </div>
                    </div>
                </div>
            `;

            $('body').append(modalHtml);
            $('body').addClass('edge-video-modal-open');

            // Focus trap for accessibility
            $('.edge-video-modal-close').focus();
        }

        closeVideoModal(e) {
            if (e) {
                e.preventDefault();
            }

            $('.edge-video-modal').remove();
            $('body').removeClass('edge-video-modal-open');
        }

        handledgescapeKey(e) {
            if (e.keyCode === 27 && $('.edge-video-modal').length) {
                this.closeVideoModal();
            }
        }

        getEmbedUrl(url) {
            // YouTube URL patterns
            const youtubeRegex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
            const youtubeMatch = url.match(youtubeRegex);

            if (youtubeMatch) {
                return `https://www.youtube.com/embed/${youtubeMatch[1]}?autoplay=1&rel=0`;
            }

            // Vimeo URL patterns
            const vimeoRegex = /(?:vimeo\.com\/)(?:.*\/)?(\d+)/;
            const vimeoMatch = url.match(vimeoRegex);

            if (vimeoMatch) {
                return `https://player.vimeo.com/video/${vimeoMatch[1]}?autoplay=1`;
            }

            // Wistia URL patterns
            const wistiaRegex = /(?:wistia\.com\/(?:medias|embed)\/|wi\.st\/)([a-zA-Z0-9]+)/;
            const wistiaMatch = url.match(wistiaRegex);

            if (wistiaMatch) {
                return `https://fast.wistia.net/embed/iframe/${wistiaMatch[1]}?autoPlay=true`;
            }

            // Direct video file
            if (this.isVideoFile(url)) {
                return url;
            }

            return null;
        }

        isVideoFile(url) {
            const videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];
            const extension = url.split('.').pop().toLowerCase();
            return videoExtensions.includes(extension);
        }
    }

    /**
     * Initialize Banner Widget
     */
    $(window).on('elementor/frontend/init', function() {
        new BannerWidget();
    });

    // Fallback for non-Elementor pages
    $(document).ready(function() {
        if (typeof elementorFrontend === 'undefined') {
            new BannerWidget();
        }
    });

})(jQuery);

// CSS for video modal (inline to ensure it's always loaded)
const modalStyles = `
    <style>
        .edge-video-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            animation: edge-modal-fade-in 0.3s ease forwards;
        }

        .edge-video-modal-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            cursor: pointer;
        }

        .edge-video-modal-content {
            position: relative;
            width: 90%;
            max-width: 900px;
            background: #000;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .edge-video-modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .edge-video-modal-close:hover {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.1);
        }

        .edge-video-modal-close svg {
            width: 20px;
            height: 20px;
            color: #333;
        }

        .edge-video-modal-iframe-wrapper {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
        }

        .edge-video-modal-iframe-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .edge-video-modal-open {
            overflow: hidden;
        }

        @keyframes edge-modal-fade-in {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {
            .edge-video-modal-content {
                width: 95%;
                margin: 20px;
            }

            .edge-video-modal-close {
                top: 5px;
                right: 5px;
                width: 35px;
                height: 35px;
            }

            .edge-video-modal-close svg {
                width: 18px;
                height: 18px;
            }
        }
    </style>
`;

// Inject modal styles
if (document.head) {
    document.head.insertAdjacentHTML('beforedgend', modalStyles);
} else {
    document.addEventListener('DOMContentLoaded', function() {
        document.head.insertAdjacentHTML('beforedgend', modalStyles);
    });
}
