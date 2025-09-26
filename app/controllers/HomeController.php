<?php
// Controlador para la página principal
class HomeController extends Controller {
    
    public function index() {
        $courseModel = $this->model('Course');
        $postModel = $this->model('Post');
        $eventModel = $this->model('Event');
        $categoryModel = $this->model('CourseCategory');
        
        // Obtener cursos destacados
        $featuredCourses = $courseModel->getPublished(3);
        
        // Obtener posts recientes
        $recentPosts = $postModel->getPublished(3);
        
        // Obtener eventos próximos
        $upcomingEvents = $eventModel->getUpcoming(3);
        
        // Obtener categorías
        $categories = $categoryModel->getAllWithCourseCount();
        
        // Obtener estadísticas
        $courseStats = $courseModel->getStats();
        $postStats = $postModel->getStats();
        $eventStats = $eventModel->getStats();
        
        $data = [
            'title' => 'EduFix - Distance Learning, Boundless Possibilities!',
            'featuredCourses' => $featuredCourses,
            'recentPosts' => $recentPosts,
            'upcomingEvents' => $upcomingEvents,
            'categories' => $categories,
            'courseStats' => $courseStats,
            'postStats' => $postStats,
            'eventStats' => $eventStats
        ];
        
        $this->view('home/index', $data);
    }
    
    public function about() {
        $data = [
            'title' => 'About Us - EduFix'
        ];
        $this->view('home/about', $data);
    }
    
    public function courses() {
        $courseModel = $this->model('Course');
        $categoryModel = $this->model('CourseCategory');
        
        $page = $_GET['page'] ?? 1;
        $limit = 9;
        $offset = ($page - 1) * $limit;
        
        $courses = $courseModel->getPublished($limit, $offset);
        $categories = $categoryModel->getAllWithCourseCount();
        $totalCourses = $courseModel->count();
        $totalPages = ceil($totalCourses / $limit);
        
        $data = [
            'title' => 'Courses - EduFix',
            'courses' => $courses,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCourses' => $totalCourses
        ];
        
        $this->view('home/courses', $data);
    }
    
    public function events() {
        $eventModel = $this->model('Event');
        
        $page = $_GET['page'] ?? 1;
        $limit = 6;
        $offset = ($page - 1) * $limit;
        
        $events = $eventModel->getUpcoming($limit, $offset);
        $totalEvents = $eventModel->count();
        $totalPages = ceil($totalEvents / $limit);
        
        $data = [
            'title' => 'Events - EduFix',
            'events' => $events,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalEvents' => $totalEvents
        ];
        
        $this->view('home/events', $data);
    }
    
    public function blog() {
        $postModel = $this->model('Post');
        $categoryModel = $this->model('CourseCategory');
        
        $page = $_GET['page'] ?? 1;
        $limit = 6;
        $offset = ($page - 1) * $limit;
        
        $posts = $postModel->getPublished($limit, $offset);
        $categories = $categoryModel->getAllWithCourseCount();
        $totalPosts = $postModel->count();
        $totalPages = ceil($totalPosts / $limit);
        
        $data = [
            'title' => 'Blog - EduFix',
            'posts' => $posts,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPosts' => $totalPosts
        ];
        
        $this->view('home/blog', $data);
    }
    
    public function contact() {
        $data = [
            'title' => 'Contact Us - EduFix'
        ];
        $this->view('home/contact', $data);
    }
}
?>
