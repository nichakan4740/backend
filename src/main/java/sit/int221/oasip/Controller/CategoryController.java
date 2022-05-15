package sit.int221.oasip.Controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;
import sit.int221.oasip.DTO.CategoryDTO;
import sit.int221.oasip.DTO.EventDTO;
import sit.int221.oasip.Entity.Event;
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

    //Get all EventCategory
    @GetMapping("")
    public List<CategoryDTO> getAllCategory(){
        return service.getAllCategory();
    }

    //Get EventCategory with id
    @GetMapping("/{id}")
    public CategoryDTO getCustomerById (@PathVariable Integer id) {
        return service.getCategoryById(id);
    }

    //Update an EventCategory with id = ?
    @PutMapping("/{id}")
    public Eventcategory update(@RequestBody Eventcategory updateCategory, @PathVariable Integer id) {
        return service.updateId(updateCategory , id);}
}
