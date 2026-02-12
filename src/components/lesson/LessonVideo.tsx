import { useState, useRef, useEffect } from "react";
import { Play, Pause, Volume2, VolumeX, Maximize, SkipForward, SkipBack } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Slider } from "@/components/ui/slider";
import { AspectRatio } from "@/components/ui/aspect-ratio";

function formatTime(seconds: number): string {
  if (!Number.isFinite(seconds) || seconds < 0) return "0:00";
  const m = Math.floor(seconds / 60);
  const s = Math.floor(seconds % 60);
  return `${m}:${s.toString().padStart(2, "0")}`;
}

/** Extract YouTube video ID from various URL formats, or null if not YouTube */
function getYouTubeVideoId(url: string): string | null {
  if (!url?.trim()) return null;
  const u = url.trim();
  // youtu.be/VIDEO_ID
  const short = u.match(/youtu\.be\/([a-zA-Z0-9_-]{11})(?:\?|$)/);
  if (short) return short[1];
  // youtube.com or m.youtube.com: watch?v=, embed/, or /v/VIDEO_ID
  const long = u.match(/(?:youtube\.com|m\.youtube\.com)\/(?:watch\?v=|embed\/|v\/)([a-zA-Z0-9_-]{11})/);
  return long ? long[1] : null;
}

interface LessonVideoProps {
  title: string;
  videoUrl?: string;
}

const LessonVideo = ({ title, videoUrl }: LessonVideoProps) => {
  const videoRef = useRef<HTMLVideoElement>(null);
  const [isPlaying, setIsPlaying] = useState(false);
  const [isMuted, setIsMuted] = useState(false);
  const [progress, setProgress] = useState(0);
  const [volume, setVolume] = useState([80]);
  const [currentTime, setCurrentTime] = useState(0);
  const [duration, setDuration] = useState(0);
  const [showControls, setShowControls] = useState(false);
  const [videoError, setVideoError] = useState(false);

  const video = videoRef.current;

  // Reset error when URL changes
  useEffect(() => {
    setVideoError(false);
  }, [videoUrl]);

  useEffect(() => {
    if (!video) return;
    video.volume = volume[0] / 100;
    video.muted = isMuted;
  }, [video, volume, isMuted]);

  useEffect(() => {
    if (!video) return;
    const onTimeUpdate = () => {
      setCurrentTime(video.currentTime);
      setProgress(video.duration ? (video.currentTime / video.duration) * 100 : 0);
    };
    const onDurationChange = () => setDuration(video.duration || 0);
    const onPlay = () => setIsPlaying(true);
    const onPause = () => setIsPlaying(false);
    const onEnded = () => setIsPlaying(false);
    video.addEventListener("timeupdate", onTimeUpdate);
    video.addEventListener("durationchange", onDurationChange);
    video.addEventListener("play", onPlay);
    video.addEventListener("pause", onPause);
    video.addEventListener("ended", onEnded);
    return () => {
      video.removeEventListener("timeupdate", onTimeUpdate);
      video.removeEventListener("durationchange", onDurationChange);
      video.removeEventListener("play", onPlay);
      video.removeEventListener("pause", onPause);
      video.removeEventListener("ended", onEnded);
    };
  }, [video]);

  const togglePlay = () => {
    if (!video) return;
    if (isPlaying) {
      video.pause();
      return;
    }
    const p = video.play();
    if (p && typeof p.catch === "function") {
      p.catch(() => setVideoError(true));
    }
  };

  const handleSeek = (val: number[]) => {
    const pct = val[0];
    if (video && duration) {
      video.currentTime = (pct / 100) * duration;
      setProgress(pct);
      setCurrentTime(video.currentTime);
    }
  };

  const skip = (delta: number) => {
    if (!video) return;
    video.currentTime = Math.max(0, Math.min(duration, video.currentTime + delta));
  };

  const toggleFullscreen = () => {
    const container = video?.parentElement;
    if (!container) return;
    if (!document.fullscreenElement) {
      container.requestFullscreen?.();
    } else {
      document.exitFullscreen?.();
    }
  };

  const hasVideo = Boolean(videoUrl?.trim());
  const youtubeId = videoUrl ? getYouTubeVideoId(videoUrl) : null;
  const isYouTube = Boolean(youtubeId);
  const showPlayer = hasVideo && (isYouTube || !videoError);

  return (
    <div className="bg-card rounded-2xl border border-border/50 shadow-card overflow-hidden ring-1 ring-border/30">
      <AspectRatio ratio={16 / 9}>
        <div
          className="w-full h-full bg-black relative group"
          onMouseEnter={() => setShowControls(true)}
          onMouseLeave={() => setShowControls(false)}
        >
          {showPlayer && isYouTube ? (
            <iframe
              src={`https://www.youtube.com/embed/${youtubeId}?rel=0&modestbranding=1`}
              title={title}
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowFullScreen
              className="absolute inset-0 w-full h-full"
            />
          ) : showPlayer ? (
            <>
              <video
                ref={videoRef}
                src={videoUrl}
                className="w-full h-full object-contain"
                playsInline
                onClick={togglePlay}
                onError={() => setVideoError(true)}
              />
              {/* Big play button when paused */}
              {!isPlaying && (
                <div
                  className="absolute inset-0 flex items-center justify-center bg-black/30 cursor-pointer"
                  onClick={togglePlay}
                >
                  <div className="w-20 h-20 rounded-full bg-primary/90 flex items-center justify-center shadow-lg hover:scale-105 transition-transform">
                    <Play className="w-10 h-10 text-primary-foreground mr-[-4px]" />
                  </div>
                </div>
              )}
              {/* Controls overlay */}
              <div
                className={`absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 transition-opacity ${
                  showControls || !isPlaying ? "opacity-100" : "opacity-0 group-hover:opacity-100"
                }`}
              >
                <div className="mb-4">
                  <Slider
                    value={[progress]}
                    onValueChange={handleSeek}
                    max={100}
                    step={0.1}
                    className="cursor-pointer"
                  />
                  <div className="flex justify-between text-xs text-white/70 mt-1">
                    <span>{formatTime(currentTime)}</span>
                    <span>{formatTime(duration)}</span>
                  </div>
                </div>
                <div className="flex items-center justify-between gap-2 flex-wrap">
                  <div className="flex items-center gap-1 sm:gap-2">
                    <Button
                      variant="ghost"
                      size="icon"
                      className="text-white hover:bg-white/20"
                      onClick={togglePlay}
                    >
                      {isPlaying ? <Pause className="w-5 h-5" /> : <Play className="w-5 h-5" />}
                    </Button>
                    <Button
                      variant="ghost"
                      size="icon"
                      className="text-white hover:bg-white/20"
                      onClick={() => skip(-10)}
                    >
                      <SkipBack className="w-5 h-5" />
                    </Button>
                    <Button
                      variant="ghost"
                      size="icon"
                      className="text-white hover:bg-white/20"
                      onClick={() => skip(10)}
                    >
                      <SkipForward className="w-5 h-5" />
                    </Button>
                    <div className="flex items-center gap-2 mr-4">
                      <Button
                        variant="ghost"
                        size="icon"
                        className="text-white hover:bg-white/20"
                        onClick={() => setIsMuted(!isMuted)}
                      >
                        {isMuted ? <VolumeX className="w-5 h-5" /> : <Volume2 className="w-5 h-5" />}
                      </Button>
                      <div className="w-16 sm:w-20 hidden sm:block">
                        <Slider
                          value={isMuted ? [0] : volume}
                          onValueChange={(val) => {
                            setVolume(val);
                            setIsMuted(val[0] === 0);
                          }}
                          max={100}
                          step={1}
                          className="cursor-pointer"
                        />
                      </div>
                    </div>
                  </div>
                  <Button
                    variant="ghost"
                    size="icon"
                    className="text-white hover:bg-white/20"
                    onClick={toggleFullscreen}
                  >
                    <Maximize className="w-5 h-5" />
                  </Button>
                </div>
              </div>
            </>
          ) : (
            <div className="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-foreground/5 to-foreground/10">
              <div className="text-center px-4">
                <div className="w-20 h-20 rounded-full gradient-hero flex items-center justify-center mx-auto mb-4 shadow-glow opacity-60">
                  <Play className="w-8 h-8 text-primary-foreground mr-[-4px]" />
                </div>
                <p className="text-muted-foreground text-sm">
                  {videoError
                    ? "تعذر تحميل الفيديو. استخدم رابط فيديو مباشر (MP4/WebM) أو رابط يوتيوب صالح من لوحة التحكم."
                    : "لا يوجد فيديو لهذا الدرس"}
                </p>
              </div>
            </div>
          )}
        </div>
      </AspectRatio>
      <div className="p-4 border-t border-border">
        <h3 className="font-semibold text-foreground arabic-text">{title}</h3>
      </div>
    </div>
  );
};

export default LessonVideo;
