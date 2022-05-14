package sit.int221.oasip.Controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import sit.int221.oasip.DTO.CategoryDTO;
import sit.int221.oasip.DTO.EventDTO;
import sit.int221.oasip.Entity.Eventcategory;
import sit.int221.oasip.Service.CategoryService;
import sit.int221.oasip.Service.EventService;

import java.util.List;

@CrossOrigin(origins = "*")
@RestController
@RequestMapping("/api/category")
class CategoryController {
    @Autowired
    private CategoryService service;

    @GetMapping("")
    public List<CategoryDTO> getAllCategory(){
        return service.getAllCategory();
    }
}
