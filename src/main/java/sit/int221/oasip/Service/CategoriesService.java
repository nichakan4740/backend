package sit.int221.oasip.Service;

import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.server.ResponseStatusException;
import sit.int221.oasip.DTO.CategoriesDTO;
import sit.int221.oasip.Entity.Categories;
import sit.int221.oasip.Repository.CategoriesRepository;
import sit.int221.oasip.Utils.ListMapper;

import java.util.List;

@Service
public class CategoriesService {
    @Autowired
    private CategoriesRepository repository;

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private ListMapper listMapper;

    //Get all Category
    public List<CategoriesDTO> getAllCategory() {
        List<Categories> eventcategories = repository.findAll();
        return listMapper.mapList(eventcategories, CategoriesDTO.class , modelMapper);
    }

    //Get category with id
    public CategoriesDTO getCategoryById(Integer id) {
        Categories categories = repository.findById(id)
                .orElseThrow(() -> new ResponseStatusException(
                        HttpStatus.NOT_FOUND, "Event id " + id +
                        "Does Not Exist !!!"
                ));

        return modelMapper.map(categories, CategoriesDTO.class);
    }

    //update category with id = ?
    public Categories updateId(@RequestBody Categories updateCategory, @PathVariable Integer id) {
        Categories categories = repository.findById(id).map(o->mapCategory(o, updateCategory))
                .orElseGet(()->
                {
                    updateCategory.setId(id);
                    return updateCategory;
                });
        return repository.saveAndFlush(categories);
    }
    private Categories mapCategory(Categories existingEvent, Categories updateEvent) {
        existingEvent.setEventCategoryName(updateEvent.getEventCategoryName());
        existingEvent.setEventCategoryDescription(updateEvent.getEventCategoryDescription());
        existingEvent.setEventDuration(updateEvent.getEventDuration());

        return existingEvent;
    }

}
