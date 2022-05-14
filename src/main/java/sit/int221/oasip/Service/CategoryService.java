package sit.int221.oasip.Service;

import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import sit.int221.oasip.DTO.CategoryDTO;
import sit.int221.oasip.DTO.EventDTO;
import sit.int221.oasip.Entity.Event;
import sit.int221.oasip.Entity.Eventcategory;
import sit.int221.oasip.Repository.EventCategoryRepository;
import sit.int221.oasip.Repository.EventRepository;
import sit.int221.oasip.Utils.ListMapper;

import java.util.List;

@Service
public class CategoryService {
    @Autowired
    private EventCategoryRepository repository;

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private ListMapper listMapper;

    public List<CategoryDTO> getAllCategory() {
        List<Eventcategory> eventcategories = repository.findAll();
        return listMapper.mapList(eventcategories, CategoryDTO.class , modelMapper);
    }

}
